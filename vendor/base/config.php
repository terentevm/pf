<?php

$config = [
    'default_controller' => 'site',
    'default_action' => 'index',
    'router' => array(
        '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)/([0-9]+)' => '$controller/$action/$id',
        '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)' => '$controller/$action',
        '([a-z0-9+_\-]+)(/)?' => '$controller',
      )
];

return $config;