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
                    $route->get('/list', "UtilitiesController:CompaniesList")->setName('companies.list');
                });
                
                $route->group('/Credittypes', function (\Slim\App $route) {
                    $route->get('', "UtilitiesController:CredittypesList")->setName('credittypes.list');
                });
                
                $route->group('/Transactiontypes', function (\Slim\App $route) {
                    $route->get('', "UtilitiesController:TransactiontypesList")->setName('transactiontypes.list');
                    $route->get('/list', "UtilitiesController:TypesList")->setName('types.list');
                });
            }
        );
        
        $app->group('/Business', function (\Slim\App $route) {
                $route->get('', "UtilitiesController:BusinessDetails")->setName('business.form');
                $route->get('/list', "UtilitiesController:BusinessDetailsList")->setName('business.list');
                $route->post('/save', "UtilitiesController:BusinessDetailsSave")->setName('business.form.save');
            }
        );

    }

    public function settingsmenu($request, $response)
    {
        return $this->view->render($response, 'pages\settingsmenu.twig', [
            "title" => "Settings Menu"
        ]);
    }
    
    public function BusinessDetails($request, $response, array $args)
    {
        $business = \TablebusinessdetailQuery::create()->findOneOrCreate();
        $business = $business->toArray();
        unset($business['Logo']);
        return $this->view->render($response, 'pages\business.twig', [
            "data"=>$business,
            "title" => "Business Details"
        ]);
    }

    
    public function BusinessDetailsList($request, $response)
    {
        $business = \TablebusinessdetailQuery::create()->findOne()->toArray();
        unset($business['Logo']);

        return $response->withJSON([
            "data"=>$business
        ]);
    }
    
    public function BusinessDetailsSave($request, $response, array $args)
    {
        $return = [];
        $return['posted'] = $request->getParsedBody();
        $business = \TablebusinessdetailQuery::create()->findOneOrCreate();

        if(isset($_REQUEST['img'])) {
            // !ddd($_FILES, $return['posted']);
            try {
                move_uploaded_file($_FILES['file']['tmp_name'], '..\public\img\logo.png');
                $return['msg'] = 'Successful Upload Post';
                $return['imgLoc'] = 'img\logo.png';
                $business->setImgLoc('img\logo.png')->save();
            } catch (\Throwable $th) {
                $return['msg'] = $th->getMessage();
            }
            return $response->withJSON($return);
        }

        try {
            $business->fromArray($return['posted'])->save();
        } catch (\Throwable $th) {
            $return['error'] = $th->getMessage() . ". \n" . $th->getPrevious();
        }

        // $return['email'] = $business->getEmailAddress1();

        return $response->withJSON($return);
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
    
    public function TypesList($request, $response)
    {
        $types = \TabletransactiontypeQuery::create()->find();
        return $response->withJSON([
            "data" => $types->toArray()
        ]);
    }

    public function CompaniesList($request, $response){
        $companies = \TablecompanydetailQuery::create()->find();
        return $response->withJSON([
            "data" => $companies->toArray()
        ]);
    }

}


