<?php

namespace tm;

use tm\Base;
use tm\MapperTrait;
use tm\Registry;
use tm\database\AbstractDb;

class Mapper extends Base
{
    use MapperTrait;

    public static function getMapper($type) {

        $type = preg_replace( '|^.*\\\|', "", $type );
        $mapper = "\\mappers\\{$type}Mapper";
        if ( class_exists( $mapper ) ) {
            return new $mapper();
        }
        throw new \Exception( "Unknown: $mapper" );
    }

    public function all() {

        $db = AbstractDb::init();
        list($sql, $params) = $db->getQueryBuilder()->build($this);

        $rows = $db->query($sql, $params);
        
        return $rows;
    }

    public function one() {
        $db = AbstractDb::init();
        
        list($sql, $params) = $db->getQueryBuilder()->build($this);

        $query_result = $db->queryOne($sql, $params);

        return $query_result;
    }

    

}