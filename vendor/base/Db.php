<?php

namespace Base;

use Base\Singleton;

class Db extends Singleton{

    protected $pdo;
    protected static  $instance;
    public static $countsql = 0;
    public static $queries = [];
    
    protected function __Construct(){
        $db = require APP . '/config/config_db.php';
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_PERSISTENT => true
        ];
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }

    
    public function prepare($sql){
        $stmt = $this->pdo->prepare($sql);
        return $stmt;
    }

        public function Execute($sql, $parametres = [])
    {
        self::$countsql ++;
        $stmt = $this->pdo->prepare($sql);
        
        try{
            $result = $stmt->execute($parametres) or die('query error');
        } 
        catch (PDOException $e) {
            $error = $e->getMessage();
            $result = FALSE;
        }
        catch (Throwable $e){
            $error = $e->getMessage();
            $result = FALSE;
        }
        return $result;
    }

    public function Query($sql, $parametres = [])
    {
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($parametres);

        if($res !==false){
            return $stmt->fetchAll();
        }
        return [];
    }
}