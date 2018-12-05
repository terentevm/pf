<?php

$loader = require dirname(__FILE__) . '/vendor/autoload.php';
$loader->addPsr4('tm\\', __DIR__ . '/vendor/');
$loader->addPsr4('cv\\', __DIR__ . '/modules/cv/');
$loader->addPsr4('app\\', __DIR__ . '/modules/app/');
$loader->addPsr4('Controllers\\', __DIR__ . '/Controllers/');
$loader->addPsr4('Models\\', __DIR__ . '/Models');
$loader->addPsr4('Mappers\\', __DIR__ . '/Mappers');
$loader->addPsr4('Views\\', __DIR__ . '/Views');
$loader->addPsr4('Reports\\', __DIR__ . '/Reports');

$loader->add('tm\\', __DIR__ . '/vendor/',true);

$loader->setUseIncludePath(true);
define('LAYOUT', 'main');
define('APP', dirname(__FILE__));
define('MODULES_PATH', dirname(__FILE__) . "\\modules");
define('MODULE_DEFAULT', "cv");
define('TEST', false);


$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true
    ],
];

$app = new Slim\App($config);

$container = $app->getContainer();

$container['conf'] = function ($container) {
    return new tm\Configuration();
};

$container['AuthManager'] = function($container) {
    
    return tm\auth\AccessManager::getAccessManager($container);
};

$container['request'] = function ($container) {
    // Replace this class with your extended implementation
    return tm\Request::createFromEnvironment($container['environment']);
};

$reg = tm\Registry::getInstance();
$reg->setContainerDI($container);

$app->add('AuthManager', 'checkAccess');

$app->add(function ($req, $res, $next) {
    $method = $req->getMethod();

    if ($method !== 'OPTIONS') {
        $res = $next($req, $res);
    }

    return $res
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->group('/{module}/{controller}[/{action}]', function () {
    $this->map(['GET', 'POST', 'DELETE', 'PUT', 'OPTIONS'], '', \tm\Router::class . ':route');
});

$app->run();