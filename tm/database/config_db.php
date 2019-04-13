<?php

return [
    'db_driver' => 'postgres',
    //'dsn' => 'mysql:host=localhost;dbname=money;charset=utf8',
    'dsn' => "pgsql:dbname=money;host=localhost;port=5432",
    'user' => 'postgres',
    'password' => '',
    'ATTR_DEFAULT_FETCH_MODE' => \PDO::FETCH_ASSOC,
    'ATTR_ERRMODE' => \PDO::ERRMODE_EXCEPTION,
    'ATTR_CURSOR' =>  \PDO::CURSOR_FWDONLY,
    'ATTR_PERSISTENT' => true
];
