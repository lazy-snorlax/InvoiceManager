<?php
namespace App\Controllers;
use App\Controllers\Controller;

class UtilitiesController extends Controller
{     

    public function index($request, $response)
    {
        return $this->view->render($response, 'root.twig');
    }  

}


