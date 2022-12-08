<?php
namespace App\Controllers;
use App\Controllers\Controller;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;
use Propel\Runtime\Map\TableMap;

class TableListController extends Controller {

    public const TABLE_DATA = [
        "invoices" => "\Tabletransactionmain",
        // TODO:  "quotes" => "\Tabletransactionmain",  ----type => 2
        "customers" => "\Tablecompanydetail",
        // TODO:  "suppliers" => "\Tablecompanydetail", ----type => 2
    ];

    public static function routes(\Slim\App $app) {
        $app->group('/List', function (\Slim\App $route) {
            $route->get('[/{dataset}]', "TableListController:list")->setName('table.list');
        });
    }

    
    public function list($request, $response, array $args)
    {
        $classname = TableListController::TABLE_DATA[strtolower($args['dataset'])];

        if (isset($args['id'])) {
            return $response->withJSON(
                $classname::findOne($args['id'])
            );
        }

        return $response->withJSON($classname::tableRender());
    }
}