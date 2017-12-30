<?php

namespace tm;

use tm\database\AbstractDb;
use tm\Mapper;
use tm\Base;

abstract class Model extends Base{
       
    
    public static function find() {
        return Mapper::getMapper(get_called_class());
    }

    public static function findByUser($user_id, $limit = 50, $offset = 0) {
        
        $result = Mapper::getMapper(get_called_class())
            ->where('user_id = :user_id')
            ->limit($limit)
            ->offset($offset)
            ->setParams(['user_id' => $user_id])
            ->all();

        return $result;    
    }

    public function findById($id) {
        $result = Mapper::getMapper(get_called_class())
            ->where('id = :id')
            ->setParams(['id' => $id])
            ->one();
            
        return $result;
    }

    public function save() {
        $success = Mapper::getMapper(get_called_class())->save($this); 
        return  $success ; 
    }

    public function delete() {
        $success = Mapper::getMapper(get_called_class())->delete();
        return  $success ;
    }

    public function load(array $attributes) {
        
        foreach ($attributes as $attrName => $attrValue) {
            $this->$attrName = $attrValue;
        }
        
    }
}