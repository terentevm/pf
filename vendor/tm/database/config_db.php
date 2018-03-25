<?php

return [
    'db_driver' => 'mysql',
    'dsn' => 'mysql:host=localhost;dbname=money;charset=utf8',
    'user' => 'php',
    'password' => '(123)',
    'ATTR_DEFAULT_FETCH_MODE' => \PDO::FETCH_ASSOC,
    'ATTR_ERRMODE' => \PDO::ERRMODE_EXCEPTION,
    'ATTR_CURSOR' =>  \PDO::CURSOR_FWDONLY,
    'ATTR_PERSISTENT' => true
];
