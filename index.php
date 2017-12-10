<?php
$loader = require dirname(__FILE__) . '/vendor/autoload.php';
$loader->addPsr4('tm\\', __DIR__ . '/vendor/');
$loader->addPsr4('Controllers\\', __DIR__ . '/Controllers/');
$loader->addPsr4('Models\\', __DIR__ . '/Models');
$loader->addPsr4('Views\\', __DIR__ . '/Views');

$loader->add('tm\\', __DIR__ . '/vendor/',true);

$loader->setUseIncludePath(true);
define('LAYOUT', 'material');
define('APP', dirname(__FILE__));

$config = require(__DIR__ . '/vendor/tm/config.php');

$reg = tm\Registry::getInstance();
$reg::$container->registerSingletons();

$app = $reg::getApp([$config]);

$app ->run();
exit();
