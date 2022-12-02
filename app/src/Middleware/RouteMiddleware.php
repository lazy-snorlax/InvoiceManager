<?php

namespace App\Middleware; 

class RouteMiddleware extends Middleware
{

    public $currentRoute = '';
    public function __invoke($request, $response, $next)
    {
        $this->currentRoute = $request->getAttribute('route')?$request->getAttribute('route')->getName():'unknown';
     
    
        $this->container->currentRoute =  $this->currentRoute ;

            
            return $next($request, $response);
    }  
}
