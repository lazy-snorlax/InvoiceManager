<?php
namespace App\Controllers;
use App\Controllers\Controller;

class SupplierController extends Controller
{
    public static function routes(\Slim\App $app) {
        $app->group('/Supplier', function (\Slim\App $route) {
                $route->get('', "SupplierController:list")->setName('suppliers.list');
            }
        );
    }

    public function list($request, $response)
    {
        return $this->view->render($response, 'list.twig', [
            "title" => "Suppliers",
            "table" => "suppliers",
            "request" => $_REQUEST,
        ]);
    }  
}


