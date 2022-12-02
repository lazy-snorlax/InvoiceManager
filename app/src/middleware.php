<?php

use Slim\App;
use Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);

    $app->add(new WhoopsMiddleware($app));
    
};
