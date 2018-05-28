<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;

/**
 * Description of WalletMapper
 *
 * @author terentyev.m
 */
class WalletMapper extends Mapper
{
    public static $db_columnes = ['id', 'user_id' ,'name', 'currency_id', 'is_creditcard', 'grace_period', 'credit_limit'];
    
    public static function setTable()
    {
        return "wallets";
    }
    
    protected function getPrimaryKey()
    {
        return 'id';
    }

    public static function getCurrency()
    {
        return [
                'model' => 'Currency',
                'f_key' => 'currency_id',
                'table_col' => 'id'
            ];
    }

    
    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_Id(),
            'name' => $obj->getName(),
            'currency_id' => $obj->getCurrency_id(),
            'is_creditcard' => intval($obj->getIs_creditcard()),
            'credit_limit' => $obj->getCredit_limit(),
            'grace_period' => $obj->getGrace_period()
        ];
        
        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
        }
        
        return $db_arr;
    }
}
