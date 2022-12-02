<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Stream;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\SuperMiddleware;
use App\Middleware\StaffMiddleware;


return function (App $app) {
    $container = $app->getContainer();
    $app->group('', function () {
        \App\Controllers\MenuController::routes($this);
        \App\Controllers\InvoiceController::routes($this);
        \App\Controllers\QuoteController::routes($this);
        \App\Controllers\CustomerController::routes($this);
        \App\Controllers\SupplierController::routes($this);
        \App\Controllers\UtilitiesController::routes($this);
    })->add(new GuestMiddleware($container));
    
    $app->group('', function() {

    })->add(new AuthMiddleware($container));
};

