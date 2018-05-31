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

    protected function afterSave($obj) 
    {
        //after save new user nesessary to create default currency and rate record for this currency, rate =1
        $userId = $obj->getId();
        $currencyId = $this->getGuide();
        
        $sysCurrency_arr = Reg::$app->config->getSystemCurrency();
                
        $currensy = new Currency();
        $currensy->setId($currencyId);    
        $currensy->setUser_id($userId);
        $currensy->setName($sysCurrency_arr['name']);
        $currensy->setShort_Name($sysCurrency_arr['short_name']) ;
        $currensy->setCode($sysCurrency_arr['code']);
        
        $currencyMapper = new CurrencyMapper(get_class($currensy));
        $success = $currencyMapper->create($currensy);

        if ($success === false) {
            return false;
        }

        $dataset = array([
            "userId" => $userId,
            "date" => "1980-01-01",
            "dateInt" => \strtotime("1980-01-01"),
            "currencyId" => $currencyId,
            "mult" => 1,
            "rate" => 1.00
        ]);

        $rates = new Rates();
        $rates->setDataset($dataset);
        
        $ratesMapper = new RatesMapper(get_class($rates));
        $ok = $ratesMapper->create($rates);

        return $ok;



    }
}
