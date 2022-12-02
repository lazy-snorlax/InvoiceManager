<?php

namespace App\Middleware;


class OldInputMiddleware extends Middleware {
 

    public function __invoke($request, $response, $next) {
           
        $old = [];
        if (isset($_SESSION['old']) ) {
            $old= $_SESSION['old'];
         }
   
        $this->container->view->getEnvironment()->addGlobal('old', $old);
        $_SESSION['old'] = $request->getParams();

        $response = $next($request, $response);
        return $response;

    }

}