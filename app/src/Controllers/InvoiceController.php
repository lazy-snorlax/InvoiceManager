<?php
namespace App\Controllers;
use App\Controllers\Controller;
use PhpParser\Node\Stmt\TryCatch;

class InvoiceController extends Controller
{
    public static function routes(\Slim\App $app) {
        $app->group('/Invoice', function (\Slim\App $route) {
                $route->get('', "InvoiceController:list")->setName('invoice.list');
                // $route->any('/data[/{id}]', "InvoiceController:invoiceList")->setName('invoice.data');
                $route->get('/form[/{id}]', "InvoiceController:invoiceForm")->setName('invoice.form');
                $route->get('/lines[/{id}]', "InvoiceController:invoiceLines")->setName('invoice.data.lines');
                $route->get('/head[/{id}]', "InvoiceController:invoiceHead")->setName('invoice.data.head');
                $route->post('/post', "InvoiceController:invoiceSave")->setName('invoice.save');
                $route->post('/title/post', "InvoiceController:invoiceTransTitleSave")->setName('invoice.title.save');
                $route->post('/item/post', "InvoiceController:invoiceTransItemSave")->setName('invoice.item.save');
            }
        );
    }

    public function list($request, $response)
    {
        return $this->view->render($response, 'list.twig', [
            "title" => "Invoices",
            "table" => "invoices",
            "btns" => [
                [
                    "label" => "New Invoice",
                    "target" => "_blank",
                    "route" => $this->router->pathFor('invoice.form', ['id'=> "new"])
                ]
            ],
            "request" => $_REQUEST
        ]);
    }

    public function invoiceForm($request, $response, array $args = []) {
        // !ddd(isset($args['id']));

        $doPDF = isset($_REQUEST['doPDF']) ? true : false;

        $invoice = null;
        $invHeader = null;
        if ($args['id'] !== "new") {
            $invoice = \TabletransactionmainQuery::create()->filterByType(1)->filterByTransactionId($request->getAttribute('id'))->findOne();
            $invHeader = \TabletransactionitemstitleQuery::create()->filterByTransactionNo($invoice->getTransactionId())->find();
        } else {
            $invoice = (new \Tabletransactionmain());
            $invHeader = (new \Tabletransactionitemstitle());
        }

        // !ddd($invoice->toArray(), $invHeader->toArray());
        
        if ($doPDF) {
            $titleNo = array_column($invHeader->toArray(), 'TitleNo');
            $invLines = \TabletransactionitemsQuery::create()->filterByTitleItem($titleNo)->find();
            $business = \TablebusinessdetailQuery::create()->findOne();
            $company = \TablecompanydetailQuery::create()->filterByCompanyId($invoice->getCompanyNo())->findOne();
            
            $render = $this->view->render($response, 'reports/invoicePDF.twig', [
                "title" => "Invoice Details - Transaction ID " . $invoice->getTransactionId(),
                "invoice" => $invoice->toArray(),
                "heads" => $invHeader->toArray(),
                "lines" => $invLines->toArray(),
                "business" => $business->toArray(),
                "company" => $company->toArray(),
            ]);
            // return $render;
            $this->generatePDF($render);
            die();
        }

        $render = $this->view->render($response, 'pages/invoices.twig', [
            "title" => "Invoice Details - Transaction ID " . $invoice->getTransactionId(),
            "invoice" => $invoice->toArray(),
            "transactions" => $invHeader->toArray(),
            "routes" => [
                "save" => $this->router->pathFor('invoice.save'),
                "titlesave" => $this->router->pathFor('invoice.title.save'),
                "itemsave" => $this->router->pathFor('invoice.item.save'),
                "companies" => $this->router->pathFor('companies.list'),
                "types" => $this->router->pathFor('types.list'),
                "business" => $this->router->pathFor('business.list'),
                "credit" => $this->router->pathFor('credit.list'),
                "expensecodes" => $this->router->pathFor('expensecodes.data.list'),
                "lines" => $this->router->pathFor('invoice.data.lines'),
                "head" => $this->router->pathFor('invoice.data.head'),
            ]
        ]);
        return $render;    
    }

    public function invoiceHead($request, $response) {
        $head = null;
        if ($_REQUEST['id'] !== "null") {
            $head = \TabletransactionitemstitleQuery::create()->filterByTransactionno($_REQUEST['id'])->find();
        } else {
            $head = new \Tabletransactionitemstitle();
        }
        
        if ($head == null) {
            $head = new \Tabletransactionitemstitle();
        }
        $head = $head->toArray();
        return $response->withJSON([
            "head" => $head,
        ]);
    }

    public function invoiceLines($request, $response) {
        $lines = \TabletransactionitemsQuery::create()->filterByTitleItem($_REQUEST['id'])->orderByItem('asc')->find();

        if ($lines ==  null) {
            $lines = new \Tabletransactionitems();
        } 

        $lines = $lines->toArray();
                
        if (isset($_REQUEST['newline'])) {
            $new = new \Tabletransactionitems();
            $new->setTitleItem($_REQUEST['id']);
            $new->setTax(0.1);
            $new->setGstCollected(0);
            $new->setCredit(0);
            // $new->setId(\TabletransactionitemsQuery::create()->filterByTitleItem($_REQUEST['id'])->orderByItem('asc')->count() >= 1 ? 1 : 1);

            $lines[] = $new->toArray();
        }

        $gst = array_sum(array_column($lines, 'GstCollected'));
        $credit = array_sum(array_column($lines, 'Credit'));
        $total = $gst + $credit;

        return $response->withJSON([
            "lines" => $lines,
            "gstTotal" => $gst,
            "creditTotal" => $credit,
            "total" => $total,
        ]);
    }

    public function invoiceSave ($request, $response) {
        $res['posted'] = $request->getParsedBody();
        try {
            if (isset($res['posted']['TransactionId'])) {
                if (($res['posted']['TransactionId']) !== "") {
                    $invoice = \TabletransactionmainQuery::create()->filterByTransactionId($res['posted']['TransactionId'])->findOne();
                    
                    $invoice->fromArray($res['posted'])->save();
                    $res['data'] = $invoice->toArray();
                    $res['msg'] = "Successful POST";
                } else {
                    $invoice = new \Tabletransactionmain();
                    unset($res['posted']['TransactionId']);
                    $invoice->fromArray($res['posted'])->save();
                    $res['data'] = $invoice->toArray();
                    $res['msg'] = "Successful POST";
                }
            }
        } catch (\Throwable $th) {
            $res['error'] = $th->getMessage() . "\n" . $th->getPrevious();
        }
        return $response->withJSON($res);
    }
    
    public function invoiceTransTitleSave($request, $response) {
        $res['posted'] = $request->getParsedBody();
        try {
            $invoiceTitle = \TabletransactionitemstitleQuery::create()->filterByTitleNo($res['posted']['id'])->findOne();
            unset($res['posted']['id']);
            if ($invoiceTitle == null){
                $invoiceTitle = new \Tabletransactionitemstitle();
            }
            $invoiceTitle->fromArray($res['posted']);
            $invoiceTitle->save();
            $res['data'] = $invoiceTitle->toArray();
        } catch (\Throwable $th) {
            $res['error'] = $th->getMessage() . "\n" . $th->getPrevious();
        }
        $titles = \TabletransactionitemstitleQuery::create()->filterByTransactionno($res['posted']['Transactionno'])->find();
        $res['titles'] = $titles->toArray();
        return $response->withJSON($res);
    }
    
    public function invoiceTransItemSave($request, $response) {
        $res['posted'] = $request->getParsedBody();
        $lineCount = \TabletransactionitemsQuery::create()->filterByTitleItem($res['posted']['TitleItem'])->orderByItem('asc')->count();
        // !ddd($res, $lineCount);
        $itemline = null;
        if ($res['posted']['Id'] == "null") {
            $itemline = new \Tabletransactionitems();
            unset($res['posted']['Id']);
            $itemline->fromArray($res['posted']);
            $itemline->setItem($lineCount + 1);
            $prevItem = \TabletransactionitemsQuery::create()->filterByTitleItem($res['posted']['TitleItem'])->count();
            $prevItem = $prevItem + 1;
            $res['posted']['Item'] = $prevItem;
        } else {
            $itemline = \TabletransactionitemsQuery::create()->filterById($res['posted']['Id'])->findOne();
            $itemline->fromArray($res['posted']);

            // Calc GST
            $tax = ($itemline->getTax())/100;
            $gst = $itemline->getCredit() * $tax;

            $itemline->setTax($tax);
            $itemline->setGstCollected($gst);
            // !ddd($gst);
        }

        $itemline->setGstCollected($res['posted']['Credit'] * $itemline->getTax());

        try {
            $itemline->save();
            $res['data'] = $itemline->toArray();
        } catch (\Throwable $th) {
            $res['error'] = $th->getMessage() . "\n" . $th->getPrevious();
        }
        
        return $response->withJSON($res);
    }

    
    private function generatePDF($request){
        \ini_set("pcre.backtrack_limit", "100000000");
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => __DIR__ . '/tmp',
            // 'mode' => 'c',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_header' => 5,
            'margin_footer' => 5
        ]);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->setFooter('Page {PAGENO} of {nbpg}');
        $mpdf->shrink_tables_to_fit = 1;
        
        $mpdf->WriteHTML($request->getBody());
        $mpdf->Output('Invoice.pdf', \Mpdf\Output\Destination::INLINE);

    }
}


