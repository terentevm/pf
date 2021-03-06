<?php

$config = [
    'lang' => 'en-GB',
    'default_module' => 'app',
    'modules_settings' => [
        'cv' => [
            'default_controller' => 'main'
        ],
        'app' => [
            'default_controller' => 'app'
        ]
    ],
    'use_csrf_token' => false,
    'http_auth' => true,
    'use_sessions' =>false,
    'jwt_from_header' => true, //if false jwt will be extracted from cookies
    'jwt_key' => 'fsfsdfdsfsdf-3dsg4t4fgdfg-g43t34t4555**-dfgdfgdfgewevdfvdn5455',
    'currensy_classificator_file' => MODULES_PATH . "/app/Models/Classificators/eur_currencies.php",
    'systemCurrency' => [
        "name"=> "Czech koruna",
        "short_name"=> "CZK",
        "code"=> "203",
        "mult"=> "1"
    ],
    'baseCurrencyList' => [
        'CZK' => [
            "name" => "Czech koruna",
            "short_name" => "CZK",
            "code" => 203
        ],
        'EUR' => [
            "name" => "Euro",
            "short_name" => "EUR",
            "code" => 978
        ],
        'RUB' => [
            "name" => "Russian rouble",
            "short_name" => "RUB",
            "code" => 643,
        ]
    ],
    'routerClass' => 'tm\Router'
];

return $config;
