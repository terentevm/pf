<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;
/**
 * Description of CurrencyMapper
 *
 * @author terentyev.m
 */
class CurrencyMapper extends Mapper
{

    public static $db_columnes = ['id', 'user_id','code', 'short_name' , 'name'];

    public static function setTable() { 
        return 'ref_currency';
    }


    protected function getPrimaryKey() {
        return 'id';
    }

    
    public function mapModelToDb(Model $obj) {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_Id(),
            'code' => $obj->getCode(),
            'short_name' => $obj->getShort_name(),
            'name' => $obj->getName()
        ];
        
        if (!isset($db_arr['id'])){
            $db_arr['id'] = $this->getGuide();
        }
        
        return $db_arr;
    }
}
