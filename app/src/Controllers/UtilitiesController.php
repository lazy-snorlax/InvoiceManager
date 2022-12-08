<?php
namespace App\Controllers;
use App\Controllers\Controller;

class UtilitiesController extends Controller
{
    
    public static function routes(\Slim\App $app) {
        $app->group('/Companies', function (\Slim\App $route) {
                $route->get('', "UtilitiesController:CompaniesList")->setName('companies.list');
            }
        );
        $app->group('/Types', function (\Slim\App $route) {
                $route->get('', "UtilitiesController:TypesList")->setName('types.list');
            }
        );
        $app->group('/Business', function (\Slim\App $route) {
                $route->get('', "UtilitiesController:BusinessDetails")->setName('business.list');
            }
        );
        $app->group('/Expensecodes', function (\Slim\App $route) {
                $route->get('', "UtilitiesController:ExpensecodeList")->setName('expensecodes.list');
            }
        );
    }

    public function CompaniesList($request, $response)
    {
        $companies = \TablecompanydetailQuery::create()->find();
        return $response->withJSON([
            "data" => $companies->toArray()
        ]);
    }

    public function TypesList($request, $response)
    {
        $types = \TabletransactiontypeQuery::create()->find();
        return $response->withJSON([
            "data" => $types->toArray()
        ]);
    }

    public function ExpensecodeList($request, $response)
    {
        $types = \TableexpensecodeQuery::create()->find();
        return $response->withJSON([
            "data" => $types->toArray()
        ]);
    }

    public function BusinessDetails($request, $response)
    {
        $business = \TablebusinessdetailQuery::create()->findOne()->toArray();
        unset($business['Logo']);
        
        return $response->withJSON([
            "data"=>$business
        ]);
    }

}


