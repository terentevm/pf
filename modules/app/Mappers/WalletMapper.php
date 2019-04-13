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
    public static $db_columns = [
        'id',
        'user_id',
        'name',
        'currency_id',
        'is_creditcard',
        'grace_period',
        'credit_limit'
    ];
    
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
    
    public function getWalletBalance($walletId) {
        $sql = "call balance(:walletId)";
        
        $param = [
            "walletId" => $walletId
        ];
        $result = $this->db->query($sql, $param);
        
        if (empty($result)) {
            return ["balance" => 0];
        }
        else {
            return ["balance" => $result[0]['balance']];
        }
       
    }
    
    public function getBalanceAllWallets(string $userId, int $dateInt)
    {
        $sql = $this->getSQL_BalanceAllWallets();
        $params = [
            'userId' => $userId,
            'date' => $dateInt
        ];
        
        $result = $this->db->query($sql, $params);
        
        return $result;
        
    }
    
    private function getSQL_BalanceAllWallets()
    {
        $sql = "select 
		temp.wallet_id,
		wallets.name as wallet,
                ref_currency.id as currencyId,
                ref_currency.name as currency,
                ref_currency.code as currencyCode,
                ref_currency.short_name as currencyCharCode,
                temp.balance as balance
                FROM (select
                        trans.wallet_id,
                        ROUND(SUM(trans.sum), 2) as balance
                from 
                        regMoneyTrans as trans
                where user_id = :userId AND dateint <= :date
                group by
                        trans.wallet_id) as temp
                left join wallets on temp.wallet_id = wallets.id
                left join ref_currency on wallets.currency_id = ref_currency.id
                where temp.balance <> 0";
        
        return $sql;
    }
}
