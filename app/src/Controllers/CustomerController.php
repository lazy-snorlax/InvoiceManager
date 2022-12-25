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
        $companies = null;
        if (isset($_REQUEST['type'])) {
            if ($_REQUEST['type'] == "customers") {
                $companies = \TablecompanydetailQuery::create()->filterByCompanyType(1)->find();
            } else if ($_REQUEST['type'] == "suppliers") {
                $companies = \TablecompanydetailQuery::create()->filterByCompanyType(2)->find();
            }
        } else {
            $companies = \TablecompanydetailQuery::create()->find();
        }
        
        // Manually sort companies by comanpy name because of broken order by statement
        $companiesList = $companies->toArray();
        $compNames = array_column($companiesList, 'CompanyName');
        $array_lowercase = array_map('strtolower', $compNames);
        (array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $companiesList));

        // !ddd($companiesList);

        return $response->withJSON([
            "companies" => $companiesList
        ]);
    }
}


