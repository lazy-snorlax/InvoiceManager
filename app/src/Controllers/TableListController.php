<?php
namespace App\Controllers;
use App\Controllers\Controller;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;
use Propel\Runtime\Map\TableMap;

class TableListController extends Controller {

    public const TABLE_DATA = [
        "invoices" => "\Tabletransactionmain",
        "quotes" => "\Tabletransactionmain",
        "customers" => "\Tablecompanydetail",
        "suppliers" => "\Tablecompanydetail",
        "expensecodes" => "\Tableexpensecode",
        "expensegroups" => "\Tableexpensegroup",
        "taxcodes" => "\Tabletaxcode",
        "companytypes" => "\Tablecompanytype",
        "credittypes" => "\Tablecredittype",
        "transactiontypes" => "\Tabletransactiontype",
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

        if ($args['dataset'] == 'quotes') {
            $render = $classname::tableRender(2);
        } else if ($args['dataset'] == 'suppliers') {
            $render = $classname::tableRender(2);
        } else {
            $render = $classname::tableRender();
        }

        return $response->withJSON($render);
    }
}