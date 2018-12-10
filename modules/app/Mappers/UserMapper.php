<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;
use app\Models\Currency;
use app\Models\Rates;
use app\Mappers\RatesMapper;
use app\Mappers\CurrencyMapper;
use tm\Registry as Reg;

class UserMapper extends Mapper
{
    public static $db_columnes = ['id', 'login', 'password','name'];
    
    public function __construct($modelClassName)
    {
        parent::__construct($modelClassName);
    }


    public static function setTable()
    {
        return "users";
    }
    
    protected function getPrimaryKey()
    {
        return 'id';
    }
    
    
    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => $obj->getId(),
            'login' => $obj->getLogin(),
            'password' => $obj->getPassword(),
            'name' => $obj->getName()
        ];
        
        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
            $obj->setId($db_arr['id']);
        }
        
        return $db_arr;
    }
    
}
