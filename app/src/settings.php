<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true,
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        'paths' => [
            'config' => __DIR__ . '/../config/',
            'temp' => __DIR__ . '/../tmp/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker'])
                ? 'php://stdout'
                : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'debug' => true,
        // Set default whoops editor
        'whoops.editor' => false,
        // Display call stack in orignal slim error when debug is off
        'displayErrorDetails' => true,
        
    ],
    'config' => [
        'sitetitle' => '',
        'sitelogo' => '',
		'maincolor'=> ''
    ],
    'pagetitles' => [],
    'menus' => [],
];
