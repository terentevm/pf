<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\database;

use tm\database\AbstractDb;
/**
 * Description of MySql
 *
 * @author terentyev.m
 */
class MySql extends AbstractDb
{
    private static $instance = null;
    
    private function __construct() {
        
        $db_config = parent::$db_config;
        
        if (empty($db_config)) {
            $db_config = require dirname(__FILE__) . '/config_db.php';    
        }
        
        $options = $this->getConnectionOptions($db_config);
        
        $this->pdo = new \PDO($db_config['dsn'], $db_config['user'], $db_config['pass'], $options);
    }
    
    public static function getInstance() {
        
        if(is_null(self::$instance))
	{
	self::$instance = new self();
	}
	return self::$instance;
    }
}
