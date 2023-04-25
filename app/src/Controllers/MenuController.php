<?php
namespace App\Controllers;
use App\Controllers\Controller;

class MenuController extends Controller
{
    public static function routes(\Slim\App $app) {
        $app->group('/', function (\Slim\App $route) {
                $route->get('', "MenuController:index")->setName('menu.home');
                $route->group('Reports', function (\Slim\App $route) {
                    $route->get('', "MenuController:reportmenu")->setName('reports.menu');
                });
            }
        );
    }

    public function index($request, $response)
    {
        return $this->view->render($response, 'menu.twig', [
            "title" => "Main Menu",
        ]);
    }

    
    public function reportmenu($request, $response) {

        $dates = \TabledefaultsettingQuery::create()->findOne();

        return $this->view->render($response, 'pages\reports.twig', [
            'title' => "Reports Dashboard",
            'start' => $dates->getDateMonthStart()->format('d/m/Y'),
            'end' => $dates->getDateMonthEnd()->format('d/m/Y'),
        ]);
    }
}


