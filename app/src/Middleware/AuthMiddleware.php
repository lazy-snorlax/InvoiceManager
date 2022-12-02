<?php

namespace App\Middleware;


class AuthMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {
       
  
        
        if (! $this->container->auth->check()) {
            $this->container->flash->addMessage('error', 'Please Login');
            return $response->withRedirect($this->container->router->pathFor('auth.login')); 
            
        } 

        $route=$request->getAttribute('route');
        if (!empty($route)) {
            $this->container->view->getEnvironment()->addGlobal('currentroute', $route->getName());
        }
       

        $response = $next($request, $response);
        return $response;

    }

}