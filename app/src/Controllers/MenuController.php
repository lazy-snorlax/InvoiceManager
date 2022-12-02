<?php
namespace App\Controllers;
use App\Controllers\Controller;

class MenuController extends Controller
{
    public static function routes(\Slim\App $app) {
        $app->group('/', function (\Slim\App $route) {
                $route->get('', "MenuController:index")->setName('menu.home');
            }
        );
    }

    public function index($request, $response)
    {
        return $this->view->render($response, 'menu.twig', [
            "title" => "Main Menu",
        ]);
    }  
}


