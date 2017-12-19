<?php

return [
    'db_driver' => 'mysql',
   // 'dsn' => 'sqlite:C:/OSPanel/domains/localhost/money_db/money.db',
    'dsn' => 'sqlite:C:/Apache/Apache24/htdocs/db/money.db',
    //'dsn' => 'mysql:host=localhost;dbname=money;charset=utf8',
    'user' => 'root',
    'pass' => '',
    'ATTR_DEFAULT_FETCH_MODE' => \PDO::FETCH_ASSOC,
    'ATTR_ERRMODE' => \PDO::ERRMODE_EXCEPTION,
    'ATTR_CURSOR' =>  \PDO::CURSOR_FWDONLY,
    'ATTR_PERSISTENT' => true
];