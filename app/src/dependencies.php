<?php

use Slim\App;
use Respect\Validation\Validator as v;
use Propel\Runtime\Propel;


return function (App $app) {
    $container = $app->getContainer();

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new Monolog\Logger($settings['name']);
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };




    // Register Twig View helper
    $container['view'] = function ($c) {
        $view = new \Slim\Views\Twig(__DIR__ . '/../templates', [
            'debug' => true,
            //'cache' => __DIR__ . '/../cache'
        ]);


        // Instantiate and add Slim specific extension
        $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
        $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));
        $view->addExtension(new Twig\Extension\DebugExtension());
        // $view->addExtension(new \App\Auth\AuthExtension());
        // $view->addExtension(new \App\Controllers\MenuExtension($c));
        // $view->addExtension(new \App\TwigFunctions());
        //   $view->addExtension(new Twig\Extra\Intl\IntlExtension());
        //   $view->addExtension(new \Concur\Resource\Twig());
        //$c->auth->user()?$c->auth->user()->toArray():null,
        // $view->getEnvironment()->addGlobal('auth', [
        //     'user' => $c->auth->username()
        // ]);

        $view->getEnvironment()->addGlobal('flash', $c->flash);

        $view->getEnvironment()->addGlobal('config', $c->get('config'));
        $view->getEnvironment()->addGlobal('menus', $c->get('menus'));
        $view->getEnvironment()->addGlobal('pagetitles', $c->get('pagetitles'));
        $view->getEnvironment()->addGlobal('currentRoute', $c->Route->currentRoute);

        return $view;
    };




    $container['validator']  = function ($container) {
        return new \App\Validation\Validator($container);
    };

    $container['flash'] = function ($c) {
        return new \Slim\Flash\Messages();
    };

    $container['csrf'] = function ($container) {
        return new \Slim\Csrf\Guard;
    };

    //-------- Classes ----------


    // $container['auth'] = function ($c) {
    //     return new \App\Auth\Auth($c);
    // };

    //-------- Controllers ----------
    $container['MenuController'] = function ($container) {
        return new \App\Controllers\MenuController($container);
    };
    $container['InvoiceController'] = function ($container) {
        return new \App\Controllers\InvoiceController($container);
    };
    $container['QuoteController'] = function ($container) {
        return new \App\Controllers\QuoteController($container);
    };
    $container['CustomerController'] = function ($container) {
        return new \App\Controllers\CustomerController($container);
    };
    $container['SupplierController'] = function ($container) {
        return new \App\Controllers\SupplierController($container);
    };
    $container['TableListController'] = function ($container) {
        return new \App\Controllers\TableListController($container);
    };

    $container['UtilitiesController'] = function ($container) {
        return new \App\Controllers\UtilitiesController($container);
    };    

    $container['Menu'] = function ($c) {
        return new \App\Auth\Menu($c);
    };
    

    
    

    //-------- Middleware ----------

    $app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
    $app->add(new \App\Middleware\OldInputMiddleware($container));
    $app->add(new \App\Middleware\CsrfViewMiddleware($container));
    $app->add(new \App\Middleware\NavMiddleware($container));


    $RouteMiddleware = new \App\Middleware\RouteMiddleware($app);
    $app->add($RouteMiddleware);
    $container['Route'] = function ($container) use ($RouteMiddleware) {
        return $RouteMiddleware;
    };


    v::with('App\\Validation\\Rules\\');
};
