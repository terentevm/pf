<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\database;

use tm\database\IConnection;

class DBCommand
{
    private $pdo = null;
    private $db = null;

    protected $stmt = null;
    protected $stmtFetchMode = \PDO::FETCH_ASSOC;
     
    protected static $db_config = [];
    
    protected $errors = [];
    
    public static $countsql = 0;
    public static $queries = [];
    
    public function __construct(IConnection $connection)
    {
        $this->pdo = $connection->getPDO();
        $this->db = $connection;
    }
    
    public function query($sql, $param = [], $newStmt = true)
    {
        if ($newStmt || $this->stmt === null) {
            $success = $this->prepare($sql);
        } else {
            $success = true;
        }

        if ($success) {
            
            $this->stmt->execute($param);
            
            return $this->stmt->fetchAll($this->stmtFetchMode);
        }
        return [];
    }

    public function queryOne($sql, $param = [])
    {
        $success = $this->prepare($sql);
        
        if ($success) {
            $this->stmt->execute($param);
            return $this->stmt->fetch($this->stmtFetchMode);
        }
        
        return [];
    }

    public function prepare(string $sql)
    {
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
            return $prepared;
        }
        
        return false;
    }

    public function run(string $sql, array $params = [])
    {
        $success = true;

        try {
            $stmt = $this->pdo->prepare($sql);
        } catch (PDOException $ex) {
            $this->db->log($ex->getMessage());
            return false;
        }

        try {
            $success = $stmt->execute($params) ;
            $success = !$this->hasErrors($stmt);

        } catch (PDOException $ex) {
            $this->db->log($ex->getMessage());
            $success = false;
        }

        return $success;
    }

    public function runStatement(\PDOStatement $stmt, array $params = []) : bool
    {
        $success = true;
        
        try {
            $success = $stmt->execute($params) ;
            $success = !$this->hasErrors($stmt);

        } catch (PDOException $ex) {
            $this->db->log($ex->getMessage());
            $success = false;
        }  
        
        return $success;

    }

    public function execute(array $param = []) : bool
    {
        
        $success = true;
        
        if (!$this->stmt instanceof \PDOStatement) {
            return false;
        }
        
        try {
            
            $success = $this->stmt->execute($param);
            $success = !$this->hasErrors($stmt);

        } catch (PDOException $ex) {
            $this->errors[] = [
                'code' => $ex->getCode(),
                'msg' => $ex->getMessage()
            ];
            
            $this->db->log($ex->getMessage());

            $success = false;

        } catch (Throwable $ex) {
            $this->errors[] = [
                'code' => $ex->getCode(),
                'msg' => $ex->getMessage()
            ];
            
            $this->db->log($ex->getMessage());

            $success = false;

        }
        
        return $success;

    }
    
    public function setFetchMode_Default() :bool
    {
        $this->stmt->setFetchMode(PDO::FETCH_ASSOC);
        return true;
    }
    
    public function setFetchMode_Class(string $className) :bool
    {
        $this->stmt->setFetchMode(PDO::FETCH_CLASS, $className);
        return true;
    }
    
    public function setFetchMode_Column(int $col) :bool
    {
        $this->stmt->setFetchMode(PDO::FETCH_COLUMN, $col);
        return true;
    }
    
    public function setFetchMode_Into($obj) :bool
    {
        $this->stmt->setFetchMode(PDO::FETCH_INTO, $obj);
        return true;
    }
    
    public function fetchAll()
    {
        $result = $this->stmt->fetchAll($this->stmtFetchMode);
        
        return $result;
    }
    
    public function fetchOne()
    {
        $result = $this->stmt->fetch($this->stmtFetchMode);
        
        return $result;
    }
    
    public function beginTransaction() :bool
    {
        return $this->pdo->beginTransaction();
    }
    
    public function commitTransaction() :bool
    {
        return $this->pdo->commit();
    }
    
    public function rollBackTransaction() :bool
    {
        return $this->pdo->rollBack();
    }
    
    public function transactionExists()
    {
        return $this->pdo->inTransaction();
    }


    public function lastInsertedId()
    {
        return $this->pdo->lastInsertId();
    }
    
    public function dump() {
        $this->stmt->debugDumpParams();    
    }

    private function hasErrors(\PDOStatement $stmt) : bool
    {
        $hasErrors = false;
        $errors = $stmt->errorInfo();
            
        if ($errors[0] !== '00000' && $errors[2] !== '') {
            $this->db->log($errors[2]);
            $hasErrors = true;
        }  

        return $hasErrors;
    }
}
