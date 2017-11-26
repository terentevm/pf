<?php
$loader = require dirname(__FILE__) . '/vendor/autoload.php';
$loader->addPsr4('Base\\', __DIR__ . '/vendor/base/');
$loader->addPsr4('Controllers\\', __DIR__ . '/Controllers/');
$loader->addPsr4('Models\\', __DIR__ . '/Models');
$loader->addPsr4('Views\\', __DIR__ . '/Views');

$loader->add('base\\', __DIR__ . '/vendor/',true);

$loader->setUseIncludePath(true);
define('LAYOUT', 'material');
define('APP', dirname(__FILE__));

$config = require(__DIR__ . '/vendor/base/config.php');

(new Base\Application($config))->Run();
