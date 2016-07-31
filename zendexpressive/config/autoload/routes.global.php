<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\ZendRouter::class,
        ],
        'factories' => [
            App\Action\HomePageAction::class => App\Action\HomePageFactory::class,
            App\Action\PingAction::class => App\Action\PingFactory::class,
            App\Action\OpenAction::class => App\Action\OpenFactory::class,
            App\Action\PlayAction::class => App\Action\PlayFactory::class,
        ],
    ],

    'routes' => [
        [
            'name'       => 'home',
            'path'       => '/',
            'middleware' => App\Action\HomePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name'       => 'api.ping',
            'path'       => '/api/ping',
            'middleware' => App\Action\PingAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name'       => 'api.open',
            'path'       => '/api/open[/:file]',
            'middleware' => App\Action\OpenAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name'       => 'api.play',
            'path'       => '/api/play[/:file]',
            'middleware' => App\Action\PlayAction::class,
            'allowed_methods' => ['GET'],
        ],
    ],
];
