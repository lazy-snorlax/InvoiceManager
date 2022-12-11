<?php
namespace App\Controllers;
use App\Controllers\Controller;

class CustomerController extends Controller
{
    public static function routes(\Slim\App $app) {
        $app->group('/Customer', function (\Slim\App $route) {
                $route->get('', "CustomerController:list")->setName('customers.list');
                $route->get('/companies', "CustomerController:companies")->setName('companies.list');
            }
        );
    }

    public function list($request, $response)
    {
        return $this->view->render($response, 'list.twig', [
            "title" => "Customers",
            "table" => "customers",
            "request" => $_REQUEST
        ]);
    }

    public function companies($request, $response) {
        $companies = \TablecompanydetailQuery::create()->find();
        return $response->withJSON([
            "companies" => $companies->toArray()
        ]);
    }
}


