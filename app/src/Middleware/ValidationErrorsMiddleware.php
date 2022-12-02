<?php

namespace App\Middleware;


class ValidationErrorsMiddleware extends Middleware {
 

    public function __invoke($request, $response, $next) {

   
        $errors = [];
        if (isset($_SESSION['errors']) ) {
            $errors= $_SESSION['errors'];
            unset( $_SESSION['errors']);
        }
   
        $this->container->view->getEnvironment()->addGlobal('errors', $errors);
     

        $response = $next($request, $response);
        return $response;

    }

}