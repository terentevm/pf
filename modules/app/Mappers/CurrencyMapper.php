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

    public static function setTable()
    {
        return 'ref_currency';
    }


    protected function getPrimaryKey()
    {
        return 'id';
    }

    
    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_Id(),
            'code' => $obj->getCode(),
            'short_name' => $obj->getShort_name(),
            'name' => $obj->getName()
        ];
        
        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
        }
        
        return $db_arr;
    }
    
    public function getRates(string $user_id, array $currencies, int $dateInt)
    {
        $sqlTemplate = $this->getSQL_Rates();
       
        
        list($paramString, $params) = $this->qb->createParamStringFromArray($currencies);
        $sql = str_replace("#paramCurrencyID#", $paramString, $sqlTemplate );
        
        $params["user_id"] = $user_id;
        $params["dateInt"] = $dateInt;

        $result = $this->db->query($sql, $params);
        
        /*$res = [
            'sql' => $sql,
            'params' => $params,
            'result' => $result
        ];    

        return $res;*/
        return $result;
    }
    
    private function getSQL_Rates()
    {
        return "select
	temp.id, 
	temp.short_name,
	temp.code,
	temp.name,
	temp.rateDate,
    rates.mult,
    rates.rate
from (Select 
	currency.id,
    currency.short_name,
	currency.code,
	currency.name,
    max(dateInt) as rateDate
FROM ref_currency as currency
	left join rates as rates on currency.id = rates.currency_id 
		AND rates.dateInt <= CAST(:dateInt AS UNSIGNED)
where currency.user_id = :user_id AND currency.id IN (#paramCurrencyID#)
group by
	currency.id,
    currency.short_name,
	currency.code,
	currency.name) as temp
	left join rates as rates on temp.id = rates.currency_id
		and temp.rateDate = rates.dateInt";
    }
    
}
