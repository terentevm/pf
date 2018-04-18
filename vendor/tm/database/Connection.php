<?php

namespace tm\database;

use tm\database\mySQLConnection;
use tm\database\SQLiteConnection;
use tm\QueryBuilder;

abstract class Connection
{

    public static function init()
    {
        $db_config = require  dirname(__FILE__) . '/config_db.php';
        
        if (!isset($db_config['db_driver'])) {
            throw new \Exception("Isn't pointed database driver type out!");
        }

        if(TEST === true) {
            return SQLiteConnection::init($db_config); 
        }

        if ($db_config['db_driver'] == 'mysql') {
            return mySQLConnection::init($db_config);
        }
        elseif ($db_config['db_driver'] == 'sqlite') {
            return SQLiteConnection::init($db_config);
        }
        else {
            throw new \Exception("Connection driver type hasn't defined or has unsupported value");
        }
    }

    
    public static function getQueryBuilder()
    {
        return new QueryBuilder();
    }


}
