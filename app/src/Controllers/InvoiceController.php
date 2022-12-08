<?php
namespace App\Controllers;
use App\Controllers\Controller;
use PhpParser\Node\Stmt\TryCatch;

class InvoiceController extends Controller
{
    public static function routes(\Slim\App $app) {
        $app->group('/Invoice', function (\Slim\App $route) {
                $route->get('', "InvoiceController:list")->setName('invoice.list');
                $route->any('/data[/{id}]', "InvoiceController:invoiceList")->setName('invoice.data');
                $route->get('/form[/{id}]', "InvoiceController:invoiceForm")->setName('invoice.form');
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
    
    public function invoiceList($request, $response, array $args = []) {
        if (isset($args['id'])) {
            // $invoice = \TabletransactionmainQuery::create()->filterByType(1)->filterByTransactionId($request->getAttribute('id'))->findOne();
            
            return $response->withJSON(
                \Tabletransactionmain::findOne($args['id'])
                // [
                //     "data" => $invoice->toArray(),
                // ]
            );
        }

        return $response->withJSON(\Tabletransactionmain::tableRender());
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
                "expensecodes" => $this->router->pathFor('expensecodes.list'),
            ]
        ]);
        return $response;    
    }

    public function invoiceSave ($request, $response) {
        return $response->withJSON([
            "msg" => "Successful POST"
        ]);
    }
}


