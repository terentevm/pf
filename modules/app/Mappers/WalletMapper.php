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
    
    public function getBalance() {
        $sql = "call balance(:walletId)";
        
       // $stmt = $this->db->prepare($sql);
        $param = [
            "walletId" => "71a801a3-6f79-11e5-8276-3065ec4b215b"
        ];
        $result = $this->db->query($sql, $param);
        
        return $result;
    }
    
    /*CREATE DEFINER=`root`@`%` PROCEDURE `balance`(in walletId varchar(36))
BEGIN
		select 
		temp.wallet_id,
		wallets.name as wallet,
		temp.balance
	FROM (select
		trans.wallet_id,
		ROUND(SUM(trans.sum), 2) as balance
	from 
		regMoneyTrans as trans
	where wallet_id = walletId
	group by
		trans.wallet_id) as temp
	left join wallets on temp.wallet_id = wallets.id
	where temp.balance <> 0;
END*/
}
