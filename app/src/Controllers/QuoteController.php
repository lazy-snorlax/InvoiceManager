<?php
namespace App\Controllers;
use App\Controllers\Controller;

class QuoteController extends Controller
{
    public static function routes(\Slim\App $app) {
        $app->group('/Quote', function (\Slim\App $route) {
                $route->get('', "QuoteController:list")->setName('quote.list');
            }
        );
    }

    public function list($request, $response)
    {
        return $this->view->render($response, 'menu.twig', [
            "title" => "Quotes"
        ]);
    }  
}


