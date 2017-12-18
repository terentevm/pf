<?php

namespace mappers;

use tm\Mapper;
/**
 * Description of CurrencyMapper
 *
 * @author terentyev.m
 */
class CurrencyMapper extends Mapper
{
    public static $db_columnes = ['id','code', 'short_name', 'name'];
    
    public static function setTable() {
        return 'dic_currency';
    }

    protected function create(\tm\Model $obj) {
        
    }

    protected function delete(\tm\Model $obj) {
        
    }

    protected function getPrimaryKey() {
        return 'id';
    }

    protected function update(\tm\Model $obj) {
        
    }

}
