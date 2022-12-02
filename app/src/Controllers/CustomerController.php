<?php
namespace App\Controllers;
use App\Controllers\Controller;

class CustomerController extends Controller
{
    public static function routes(\Slim\App $app) {
        $app->group('/Customer', function (\Slim\App $route) {
                $route->get('', "CustomerController:list")->setName('customers.list');
            }
        );
    }

    public function list($request, $response)
    {
        return $this->view->render($response, 'menu.twig', [
            "title" => "Customers"
        ]);
    }  
}


