<?php

namespace tm;

use tm\Base;
use tm\Model;
use tm\MapperTrait;
use tm\Registry;
use tm\database\Connection;
use tm\database\DBCommand;
use tm\helpers\QueryBuilderHelper as QBH;

abstract class Mapper extends Base
{
    use MapperTrait;
    
    protected $db_connection = null;
    protected $db = null;
    protected $qb = null;
    protected $modelClassName;
    protected static $mapperStorage = [];
    protected $create_stmt = null;
    protected $update_stmt = null;
    protected $delete_stmt = null;

    public function __construct($modelClassName)
    {
        if ($this->db_connection === null) {
            try {
                $this->db_connection = Connection::init();
            } catch (\Throwable $e) {
                throw new \Exeption($e->getMessage());
                return;
            }
            
        }
        
        if ($this->db === null) {
            $this->db = new DBCommand($this->db_connection);
        }
        
        if ($this->qb === null) {
            $this->qb = Connection::getQueryBuilder();
        }
        
        $this->modelClassName = $modelClassName;
    }

    public static function getMapper($type)
    {
        $modelClassName = $type;

       
        $type = preg_replace('|^.*\\\|', "", $type);
        $currentModule = CURRENT_MUDULE;
        $mapper = "\\{$currentModule}\\mappers\\{$type}Mapper";
        
        if (class_exists($mapper)) {

            //check if mapper object has been already created - return from storage

            if (array_key_exists($mapper, self::$mapperStorage)) {
                return self::$mapperStorage[$mapper];
            }

            try {
                $mapperInstance = new $mapper($modelClassName);
            } catch (\Throwable $e) {
                throw new \Exeption($e->getMessage());
                return;
            }
            
            self::$mapperStorage[$mapper] = $mapperInstance;
            return $mapperInstance;
        }

        throw new \Exception("Unknown: $mapper");
    }

    public function getDb()
    {
        return $this->db;
    }

    public function all()
    {
        list($sql, $params) = $this->qb->build($this);

        $rows = $this->db->query($sql, $params);

        $result_data = $this->processRelations($rows);

        return $result_data;
    }

    public function one()
    {
        list($sql, $params) = $this->qb->build($this);

        $query_result = $this->db->queryOne($sql, $params);

        if ($query_result === false) {
            return null;
        }

        if ($this->asArray) {
            return $query_result;
        }

        $model = $this->dbRecordToModel($query_result);

        return $model;
    }



    public function processRelations(&$data)
    {
        if (empty($this->with)) {
            return $data;
        }

        foreach ($this->with as $table) {
            $this->processRelation($data, $table);
        }

        return $data;
    }

    public function processRelation(&$data, $tableName)
    {
        $relation = $this->getRelation($tableName);

        $keys_arr = $this->getKeysArray($data, $relation['f_key']);

        if (is_null($keys_arr)) {
            throw new \Exception("Primary model doesn't contain foreign key {$relation['f_key']}");
        }

        $this->addDataFromForeignTable($data, $keys_arr, $tableName, $relation);

        return $data;
    }

    protected function addDataFromForeignTable(&$data, $keys_arr, $tableName, $relation)
    {
        
        list($condition, $inParams) =QBH::inCondition($relation['table_col'], $keys_arr);

        $currentModule = CURRENT_MUDULE;
        $class_name = "\\" . $currentModule . '\\models\\' . $relation['model'];

        $rows = $class_name::find()->where([$condition])->setParams($inParams)->all();

        $result = $this->addRelationsToResult($data, $rows, $relation['f_key'], $relation['table_col'], $tableName);

        return $result;
    }

    public function getRelation($tableName)
    {
        $method_name = 'get' . ucfirst($tableName);

        if (method_exists($this, $method_name)) {
            $relations = $this->$method_name();

            if (!is_array($relations)) {
                throw new \Exception("Method {$method_name} isn't returned array");
            }
        } else {
            $class_name = get_class($this);
            throw new \Exception("Mapper class {$class_name} doesn't contain getter-method {$method_name} ");
        }

        return $relations;
    }

    public function getKeysArray(&$data, $column_key)
    {
        return array_column($data, $column_key);
    }

    protected function addRelationsToResult(&$primary_arr, $relations_arr, $f_key, $table_column, $relation_name)
    {
        $search_arr = array_combine(array_column($relations_arr, $table_column), $relations_arr);

        foreach ($primary_arr as &$item) {
            $str_rel = $search_arr[$item[$f_key]];
            $item[$relation_name] = $str_rel;
        }

        return $primary_arr;
    }

    public function performToModels(array $rows)
    {
        $models = [];

        foreach ($rows as $row) {
            $models[] = $this->dbRecordToModel($row);
        }

        return $models;
    }

    public function dbRecordToModel($record)
    {
        $model = Registry::CreateObject($this->modelClassName);
        $model->load($record);
        return $model;
    }

    public function save(Model $obj, $upload_mode = false, $useTransaction = false)
    {
        if (!$this->db->transactionExists() && $useTransaction) {
            $this->db->beginTransaction();
        }

        $success = $this->create($obj);

        if ($success) {
            $success = $this->afterSave($obj);
        }

        if ($this->db->transactionExists() && $useTransaction) {
            if ($success) {
                $this->db->commitTransaction();
            } else {
                $this->db->rollBackTransaction();
            }
        }


        return $success;
    }

    protected function create(Model $obj)
    {
        if ($this->create_stmt === null) {
            $sql = $this->qb->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }

        $param = $this->mapModelToDb($obj);

        $success = $this->create_stmt->execute($param);

        return $success;
    }
    
    public function update(Model $obj, array $colsForUpdate)
    {
        $sql = $this->qb->buildUpdate($this, $colsForUpdate);
        $this->update_stmt = $this->db->prepare($sql);

        $success = $this->update_stmt->execute($colsForUpdate);
        
        if ($success === true) {
            $success = $this->afterUpdate($obj);
        }

        
        return $success;

    }

    protected function afterSave($obj)
    {
        return true;
    }

    protected function afterUpdate($obj)
    {
        return true;
    }

    public function delete()
    {
        $sql = $this->qb->buildDelete($this);
        $this->delete_stmt = $this->db->prepare($sql);
        
        if ($this->delete_stmt === false) {
            return false;
        }
        
        $success = $this->delete_stmt->execute($this->params);
        
        return $success;
    }

    abstract protected function getPrimaryKey();

    abstract public function mapModelToDb(Model $obj);
}
