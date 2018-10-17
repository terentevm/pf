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