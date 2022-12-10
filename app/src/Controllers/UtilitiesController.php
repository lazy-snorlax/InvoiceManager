<?php
namespace App\Controllers;
use App\Controllers\Controller;

class UtilitiesController extends Controller
{
    
    public static function routes(\Slim\App $app) {
        $app->group('/Settings', function (\Slim\App $route) {
                $route->get('', "UtilitiesController:settingsmenu")->setName('settings.menu');

                
                $route->group('/Expensecodes', function (\Slim\App $route) {
                    $route->get('', "UtilitiesController:ExpensecodeList")->setName('expensecodes.list');
                });
                
                $route->group('/Expensegroups', function (\Slim\App $route) {
                    $route->get('', "UtilitiesController:ExpensegroupList")->setName('expensegroups.list');
                });
                
                $route->group('/Taxcodes', function (\Slim\App $route) {
                    $route->get('', "UtilitiesController:TaxcodeList")->setName('taxcodes.list');
                });
                
                $route->group('/Companytypes', function (\Slim\App $route) {
                    $route->get('', "UtilitiesController:CompanytypesList")->setName('companytypes.list');
                });
                
                $route->group('/Credittypes', function (\Slim\App $route) {
                    $route->get('', "UtilitiesController:CredittypesList")->setName('credittypes.list');
                });
                
                $route->group('/Transactiontypes', function (\Slim\App $route) {
                    $route->get('', "UtilitiesController:TransactiontypesList")->setName('transactiontypes.list');
                });
            }
        );
        
        $app->group('/Business', function (\Slim\App $route) {
                $route->get('', "UtilitiesController:BusinessDetails")->setName('business.list');
            }
        );

    }

    public function settingsmenu($request, $response)
    {
        return $this->view->render($response, 'pages\settingsmenu.twig', [
            "title" => "Settings Menu"
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

    public function ExpensecodeList($request, $response)
    {
        return $this->view->render($response, 'list.twig', [
            "title" => "Expense Codes",
            "table" => "expensecodes",
            "request" => $_REQUEST,
        ]);
    }

    public function ExpensegroupList($request, $response)
    {
        return $this->view->render($response, 'list.twig', [
            "title" => "Expense Groups",
            "table" => "expensegroups",
            "request" => $_REQUEST,
        ]);
    }

    public function TaxcodeList($request, $response)
    {
        return $this->view->render($response, 'list.twig', [
            "title" => "Tax Codes",
            "table" => "taxcodes",
            "request" => $_REQUEST,
        ]);
    }

    public function CompanytypesList($request, $response)
    {
        return $this->view->render($response, 'list.twig', [
            "title" => "Company Types",
            "table" => "companytypes",
            "request" => $_REQUEST,
        ]);
    }

    public function CredittypesList($request, $response)
    {
        return $this->view->render($response, 'list.twig', [
            "title" => "Credit Types",
            "table" => "credittypes",
            "request" => $_REQUEST,
        ]);
    }

    public function TransactiontypesList($request, $response)
    {
        return $this->view->render($response, 'list.twig', [
            "title" => "Transaction Types",
            "table" => "transactiontypes",
            "request" => $_REQUEST,
        ]);
    }

}


