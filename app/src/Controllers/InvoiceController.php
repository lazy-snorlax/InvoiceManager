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
        ]);
    }
    
    public function invoiceList($request, $response, array $args = []) {
        if (isset($args['id'])) {
            $invoice = \TabletransactionmainQuery::create()->filterByType(1)->filterByTransactionId($request->getAttribute('id'))->findOne();

            return $response->withJSON([
                "data" => $invoice->toArray(),
            ]);
        }

        $invoice = \TabletransactionmainQuery::create()->filterByType(1)->find();
        
        return $response->withJSON([
            "data" => $invoice->toArray(),
            "columns" => \Tabletransactionmain::tableColumns(),
            "permissions" => \Tabletransactionmain::permissions(),
            "primarykey" => \Tabletransactionmain::$primaryKey,
            "route" => $this->router->pathFor(\Tabletransactionmain::$route)
        ]);
    }

    public function invoiceForm($request, $response, array $args = []) {
        $invoice = \TabletransactionmainQuery::create()->filterByType(1)->filterByTransactionId($request->getAttribute('id'))->findOne();
        return $this->view->render($response, 'pages/invoices.twig', [
            "title" => "Invoice Details - Transaction ID " . $invoice->getTransactionId(),
            "invoice" => $invoice->toArray()
        ]);
        return $response;    
    }

    public function invoiceSave ($request, $response) {
        return $response->withJSON([
            "msg" => "Successful POST"
        ]);
    }
}


