<?php

namespace App\Middleware; 

class NavMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        //Cleaned up to handle partial loading better
        $nav = (isset($_SESSION['nav']))? $_SESSION['nav']:[];
       
        $_SESSION['nav'] = $nav;

        $this->container->view->getEnvironment()->addGlobal('nav', $nav);
 
        $response = $next($request, $response);
        return $response;
    }

    public function getConfigFile($named)
    {
        return realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config').DIRECTORY_SEPARATOR.$named;
    }
}
