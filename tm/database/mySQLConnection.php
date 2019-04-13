<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\database;

use tm\database\IConnection;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class mySQLConnection implements IConnection
{
    private static $instance = null;
    private $loger = null;
    protected $pdo = null;
    
    private $dsn;
    private $user = null;
    private $password = null;
    
    private function __construct($db_config)
    {
        $this->dsn = $db_config['dsn'];
        $this->user = $db_config['user'];
        $this->password = $db_config['password'];
        
        $connOptions = $this->getConnectionOptions($db_config);
        
        $this->pdo = new \PDO($this->dsn, $this->user, $this->password, $connOptions);
        
        $this->loger = new Logger('mysql');
        $this->loger->pushHandler(new StreamHandler(APP . '/logs/db/mysql.log', Logger::WARNING));
    }
    
    protected function __clone()
    {
    }
    
    protected function __sleep()
    {
    }
    
    protected function __wakeup()
    {
    }
    
    public static function init($config)
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }
    
    public function log(string $message)
    {
        $this->loger->error($message); 
    }

    protected function getConnectionOptions(array &$db_config) : array
    {
        $options = [];
        
        if (array_key_exists('ATTR_DEFAULT_FETCH_MODE', $db_config)) {
            $options['ATTR_DEFAULT_FETCH_MODE'] = $db_config['ATTR_DEFAULT_FETCH_MODE'] ;
        }
        
        if (array_key_exists('ATTR_ERRMODE', $db_config)) {
            $options['ATTR_ERRMODE'] = $db_config['ATTR_ERRMODE'] ;
        }
        
        if (array_key_exists('ATTR_CURSOR', $db_config)) {
            $options['ATTR_CURSOR'] = $db_config['ATTR_CURSOR'] ;
        }
        
        if (array_key_exists('ATTR_PERSISTENT', $db_config)) {
            $options['ATTR_PERSISTENT'] = $db_config['ATTR_PERSISTENT'] ;
        }
        
        return $options;
    }
    
    public function callFunction(string $funcName , array $funcParams = [])
    {
        $sql = 'CALL ' . $funcName;
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute($funcParams);
        $errors = $stmt->errorInfo();

        if ($errors[0] !== '00000' && $errors[2] !== '') {
            $this->log($errors[2]);
            $success = false;
        }
        return $success;
    }

    public function beginTransaction()
    {
    }

    public function commitTransaction()
    {
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function rollBackTransaction()
    {
    }
}
