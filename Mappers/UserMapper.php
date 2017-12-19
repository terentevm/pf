<?php

namespace mappers;
use tm\Mapper;
use tm\Model;

class UserMapper extends Mapper
{
    public static $db_columnes = ['id', 'login', 'password','name'];
    
    private $create_stmt = null;
    private $update_stmt = null;
    private $delete_stmt = null;
    
    private  $sql_create = "INSERT INTO users (id, login, password, name) VALUES (:id, :login, :password, :name)";

    public function __construct($modelClassName) {
        parent::__construct($modelClassName);
        
        
    }


    public static function setTable() {
        return "users";
    }
    
    protected function getPrimaryKey() {
        return 'id';
    }
    
    protected function create(Model $obj) {
       
        if ($this->create_stmt === null) {
            $this->create_stmt = $this->db->prepare($this->sql_create);
        }
        
        $db_vars = $this->mapModelToDb($obj);
        
        $success = $this->create_stmt->execute($db_vars);
        
        return $success;
    }
    
    protected function update(Model $obj) {
            
    }
    
    protected function delete(Model $obj) {
            
    }
    
    protected function mapModelToDb(Model $obj) {
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