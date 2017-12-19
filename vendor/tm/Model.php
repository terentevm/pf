<?php

namespace tm;

use tm\database\AbstractDb;
use tm\Mapper;
use tm\Base;

abstract class Model extends Base{
       
    
    public static function find() {
        return Mapper::getMapper(get_called_class());
    }

    public function save() {
        $success = Mapper::getMapper(get_called_class())->save($this); 
        return  $success  
    }

    public function load(array $attributes) {
        
        foreach ($attributes as $attrName => $attrValue) {
            $this->$attrName = $attrValue;
        }
        
    }
}