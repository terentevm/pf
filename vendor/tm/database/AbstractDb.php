<?php

namespace tm\database;

use tm\database\DatabaseInterface;

abstract class AbstractDb implements DatabaseInterface
{

    protected $pdo = null;
    protected $stmt = null;
    protected $stmtFetchMode = \PDO::FETCH_ASSOC;
     
    protected static $db_config = [];
    
    protected $errors = [];
    
    public static $countsql = 0;
    public static $queries = [];
    
    public static function init() {
        $db_config = require  dirname(__FILE__) . '/config_db.php';
        
        self::$db_config = $db_config;
        
        if ($db_config['db_driver'] == 'sqllite') {
            return Sqlite::getInstance();
        }
        elseif ($db_config['db_driver'] == 'mysql') {
            return Mysql::getInstance();
        }
        else {
            return null;
        }
    }


    protected function __clone() {
    }
    
    protected function __sleep() {
    }
    
    protected function __wakeup() {
    }
    
    protected function getConnectionOptions(array &$db_config) : array {
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
    
    public function prepare(string $sql) : bool{
        try {
            $prepared = $this->pdo->prepare($sql);
            
        } catch (PDOException $ex) {
            $this->errors[] = [
                'code' => $ex->getCode(),
                'msg' => $ex->getMessage()
            ];
            
            return false;
        }
       
        if ($prepared instanceof \PDOStatement) {
            $this->stmt = $prepared; 
            return true;
        }
        
       return false; 
    }

    public function execute(array $param = []) : bool {
        
        if (!$this->stmt instanceof \PDOStatement) {
            return false;
        }
        
        try {
            $this->stmt->execute($param);
            return true;
        } 
        catch (PDOException $ex) {
            
            $this->errors[] = [
                'code' => $ex->getCode(),
                'msg' => $ex->getMessage()
            ];
        }
        catch (Throwable $ex){
            $this->errors[] = [
                'code' => $ex->getCode(),
                'msg' => $ex->getMessage()
            ];
        }
        return false;
    }
    
    public function setFetchMode_Default() :bool {
        $this->stmt->setFetchMode(PDO::FETCH_ASSOC);
        return true;
    }
    
    public function setFetchMode_Class(string $className) :bool {
        $this->stmt->setFetchMode(PDO::FETCH_CLASS, $className);
        return true;    
    }
    
    public function setFetchMode_Column(int $col) :bool {
       $this->stmt->setFetchMode(PDO::FETCH_COLUMN, $col);
       return true; 
    }
    
    public function setFetchMode_Into($obj) :bool {
       $this->stmt->setFetchMode(PDO::FETCH_INTO, $obj);
       return true;  
    }
    
    public function fetchAll() {
        $result = $this->stmt->fetchAll($this->stmtFetchMode);
        
        return $result;
    }
    
    public function fetchOne() {
        $result = $this->stmt->fetch($this->stmtFetchMode);
        
        return $result;
    }
    
    public function beginTransaction() :bool {
        return $this->pdo->beginTransaction();

    }
    
    public function commitTransaction() :bool {
        return $this->pdo->commit();

    }
    
    public function rollBackTransaction() :bool {
        return $this->pdo->rollBack();
    }
}