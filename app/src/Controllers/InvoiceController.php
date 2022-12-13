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
                $route->get('/data[/{id}]', "InvoiceController:invoiceLines")->setName('invoice.data.lines');
                $route->post('/post', "InvoiceController:invoiceSave")->setName('invoice.save');
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
                "companies" => $this->router->pathFor('companies.list'),
                "types" => $this->router->pathFor('types.list'),
                "business" => $this->router->pathFor('business.list'),
                "expensecodes" => $this->router->pathFor('expensecodes.data.list'),
                "lines" => $this->router->pathFor('invoice.data.lines'),
            ]
        ]);
        return $response;    
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
        return $response->withJSON([
            "msg" => "Successful POST"
        ]);
    }
}


