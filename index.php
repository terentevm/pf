<?php
$loader = require dirname(__FILE__) . '/vendor/autoload.php';
$loader->addPsr4('tm\\', __DIR__ . '/vendor/');
$loader->addPsr4('cv\\', __DIR__ . '/modules/cv/');
$loader->addPsr4('app\\', __DIR__ . '/modules/app/');
$loader->addPsr4('Controllers\\', __DIR__ . '/Controllers/');
$loader->addPsr4('Models\\', __DIR__ . '/Models');
$loader->addPsr4('Mappers\\', __DIR__ . '/Mappers');
$loader->addPsr4('Views\\', __DIR__ . '/Views');

$loader->add('tm\\', __DIR__ . '/vendor/',true);

$loader->setUseIncludePath(true);
define('LAYOUT', 'main');
define('APP', dirname(__FILE__));
define('MODULES_PATH', dirname(__FILE__) . "\\modules");
define('MODULE_DEFAULT', "cv");
define('TEST', false);

$reg = tm\Registry::getInstance();
$reg::$container->registerSingletons();

$app = $reg->getApp();

$app ->run();
exit();
