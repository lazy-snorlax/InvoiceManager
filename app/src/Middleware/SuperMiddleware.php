<?php

namespace App\Middleware;



class SuperMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {


 

        //TODO check if user is super user

        
        if (false) {
	        $this->container->flash->addMessage('error', 'Super User Required');
            return $response->withRedirect($this->container->router->pathFor('siteroot')); 
        } 


        $response = $next($request, $response);
        return $response;

    }

}