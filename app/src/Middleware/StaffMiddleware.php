<?php

namespace App\Middleware;
use StaffQuery;
use AuthQuery;


class StaffMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {

        // $response = $next($request, $response);
        // return $response;
        // !d("bfhhbf");
        // die();

        $user = NULL;
        $staffLevel = NULL;

        
        if(isset($_SESSION['staff'])){


            if($_SESSION['staff'] == true){

                // getting data of user currently signed in
                $user = StaffQuery::create()->findByUsername($_SESSION['user'])->toArray();
                
                // getting the staff level of the user currently logged in
                $staffLevel = AuthQuery::create()->findById($user[0]['StaffLevel'])->toArray();
                
                // switch statement for all staff levels
                switch ($staffLevel[0]['Id']) {
                    case 0:

                        // staff with level 0 will not have access to Dietitian page
                        if($request->getUri()->getPath() == 'Dietitian'){
                
                            return $response->withRedirect($this->container->router->pathFor('patients.All')); 

                        }

                        $response = $next($request, $response);
                        return $response;
                    break;
                    case 1:
                        // staff with level 1 (Dietitian) will have access to all pages
                        if($request->getUri()->getPath() == 'Admin'){
                
                            return $response->withRedirect($this->container->router->pathFor('Dietitian.All')); 

                        }
                        
                        $response = $next($request, $response);
                        return $response;
                    break;
                    case 5:
                        // Admins @ level 5 will have access to all pages

                        
                        $response = $next($request, $response);
                        return $response;
                    break;
                    default:
                }
                $response = $next($request, $response);
                return $response;
            };


            // returning user to the login as they would be staff without any staff level
            $this->container->flash->addMessage('error', 'Trying to access an unauthorised page, returning to login');
                
            return $response->withRedirect($this->container->router->pathFor('auth.login')); 

    

        }

    }

}