<?php

namespace tm\database;

use tm\database\mySQLConnection;
use tm\QueryBuilder;

class Connection
{
    
    protected function __construct()
    {
        $db_config = require  dirname(__FILE__) . '/config_db.php';
        
        $this->dsn = $db_config['dsn'];
        $this->user = $db_config['user'];
        $this->password = $db_config['password'];
        
        $connOptions = $this->getConnectionOptions($db_config);
        
        $this->pdo = new \PDO($this->dsn, $this->user, $this->password, $connOptions);
    }

    public static function init()
    {
        $db_config = require  dirname(__FILE__) . '/config_db.php';
        
        if ($db_config['db_driver'] == 'mysql') {
            return mySQLConnection::init($db_config);
        }
        else {
            throw new \Exception("Connection driver type hasn't defined or has unsupported value");
        }
    }

    
    public function getQueryBuilder()
    {
        return new QueryBuilder();
    }


}
