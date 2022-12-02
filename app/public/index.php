<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

ini_set('session.gc_maxlifetime', 43200);
session_set_cookie_params(43200);
session_start();
/* 
echo "jh";
die(); */

set_time_limit(3600);
error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set('Australia/Adelaide');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/global.php';
require __DIR__ . '/../config/config.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
$dependencies = require __DIR__ . '/../src/dependencies.php';
$dependencies($app);

// Register middleware
$middleware = require __DIR__ . '/../src/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . '/../src/routes.php';
$routes($app);




// Run app
$app->run();





