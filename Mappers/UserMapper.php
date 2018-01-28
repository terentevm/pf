<?php

namespace mappers;
use tm\Mapper;
use tm\Model;

class UserMapper extends Mapper
{
    public static $db_columnes = ['id', 'login', 'password','name'];
    
    public function __construct($modelClassName) {
        parent::__construct($modelClassName);
               
    }


    public static function setTable() {
        return "users";
    }
    
    protected function getPrimaryKey() {
        return 'id';
    }
    
    
    protected function update(Model $obj) {
    
        if ($this->update_stmt === null) {
            $this->where = ['id = :id'];

            $sql = $this->db->getQueryBuilder()->buildUpdate($this);
            $this->update_stmt = $this->db->prepare($sql);
        }
        
        $param = $this->mapModelToDb($obj);
        $success = $this->create_stmt->execute($param);

        return $success;
    }
    
    public function delete(Model $obj) {
        if ($this->delete_stmt === null) {
            $this->where = ['id = :id'];

            $sql = $this->db->getQueryBuilder()->buildDelete($this);
            $this->delete_stmt = $this->db->prepare($sql);
        }
        
        //$param = $this->mapModelToDb($obj);
        $param = ['id' => $obj->getId()];
        $success = $this->delete_stmt->execute($param);

        return $success;      
    }
    
    public function mapModelToDb(Model $obj) {
        $db_arr = [
            'id' => $obj->getId(),
            'login' => $obj->getLogin(),
            'password' => $obj->getPassword(),
            'name' => $obj->getName()
        ];
        
        if (!isset($db_arr['id'])){
            $db_arr['id'] = $this->getGuide();
        }
        
        return $db_arr;
    }
}