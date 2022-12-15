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
            "request" => $_REQUEST
        ]);
    }

    public function invoiceForm($request, $response, array $args = []) {
        $invoice = \TabletransactionmainQuery::create()->filterByType(1)->filterByTransactionId($request->getAttribute('id'))->findOne();
        $invHeader = \TabletransactionitemstitleQuery::create()->filterByTransactionNo($invoice->getTransactionId())->find();

        // !ddd($invoice->toArray(), $invHeader->toArray());

        return $this->view->render($response, 'pages/invoices.twig', [
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
                "expensecodes" => $this->router->pathFor('expensecodes.data.list'),
                "lines" => $this->router->pathFor('invoice.data.lines'),
                "head" => $this->router->pathFor('invoice.data.head'),
            ]
        ]);
        return $response;    
    }

    public function invoiceHead($request, $response) {
        $head = \TabletransactionitemstitleQuery::create()->filterByTransactionno($_REQUEST['id'])->find();

        if ($head ==  null) {
            $head = new \Tabletransactionitemstitle();
        }
        $head = $head->toArray();
        return $response->withJSON([
            "head" => $head,
        ]);
    }

    public function invoiceLines($request, $response) {
        $lines = \TabletransactionitemsQuery::create()->filterByTitleItem($_REQUEST['id'])->find();

        if ($lines ==  null) {
            $lines = new \Tabletransactionitems();
        }

        $lines = $lines->toArray();

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
                $invoice = \TabletransactionmainQuery::create()->filterByTransactionId($res['posted']['TransactionId'])->findOne();
                
                $invoice->fromArray($res['posted'])->save();
                $res['data'] = $invoice->toArray();

                $res['msg'] = "Successful POST";
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
            // !ddd($res['posted'], $invoiceTitle->toArray());
            // $invoiceTitle->setTransactionno($res['posted']['transid']);
            // $invoiceTitle->setTitleDescription($res['posted']['title']);
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
        return $response->withJSON($res);
    }
}


