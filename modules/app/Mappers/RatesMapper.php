<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;
use tm\helpers\QueryBuilderHelper as QBH;

class RatesMapper extends Mapper
{
    public static $db_columns = [
        'id',
        'user_id',
        'date',
        'date_int',
        'currency_id',
        'mult',
        'rate'
    ];

    public static function setTable()
    {
        return 'rates';
    }
    
    protected function getPrimaryKey()
    {
        return 'id';
    }

    public function create(Model $obj)
    {
        if ($this->create_stmt === null) {
            // $sql = $this->qb->buildInsert($this);
            $sql = "INSERT INTO public.rates (user_id, date, dateint, currency_id, mult, rate) VALUES (:user_id,:date,:dateint,:currency_id,:mult,:rate)";
            $this->create_stmt = $this->db->prepare($sql);
        }

        $dataset = $obj->getDataset();

        if (is_null($dataset)) {
            return false;
        }

        foreach ($dataset->strings() as $record) {
            
            $params = $this->mapModelToDb($record);
            $success = $this->db->runStatement($this->create_stmt, $params);

            if ($success !== true) {
                return false;
            }
        }
        
        return true;
    }
    
    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'user_id' => $obj->getUserId(),
            'date' => $obj->getDate(),
            'dateint' => $obj->getDateInt(),
            'currency_id' => $obj->getCurrencyId(),
            'mult' => $obj->getMult(),
            'rate' => $obj->getRate()
        ];
        
        return $db_arr;
    }

    public function getLastRates(string $userId, int $dateInt, $currencies = [])
    {
        $params = [
            "used_id" => $userId,
            "dateint" => $dateInt
        ];

        if (count($currencies) > 0) {
           
            list($paramString, $params) = QBH::createInParamString($currencies, "curr");

            foreach($params as $key => $value) {
                $params[$key] = $value; 
            }

            $sql = $this->getSQL_LastRates($paramString);
        }
        else {
            $sql = $this->getSQL_LastRates();
        }

        $result = $this->db->query($sql, $params);
        
        $result_accoc = [];
        
        if (!empty($result)) {
            foreach($result  as $record) {
                $id = $record['curr_id'];
                $result_accoc[$id] = [
                    "rate" => $record['rate'],
                    "mult" => $record['mult']
                ];   
            }
        }
        
        return $result_accoc;
        
    }

    private function getSQL_LastRates($currenciesCondStr = "")
    {
        $sql = 
        "SELECT
        ratesByDate.curr_id,
        ratesByDate.max_date,
        reg.rate,
        reg.mult
        FROM 
        (SELECT 
            rates.currency_id as curr_id,
            MAX(rates.dateint) as max_date
            FROM rates WHERE user_id = :user_id AND rates.dateint < :dateint #currenciesCondStr#
        GROUP BY
            rates.currency_id) as rates_by_date
        LEFT JOIN rates as reg on rates_by_date.curr_id = reg.currency_id AND rates_by_date.max_date = reg.dateint";

        if ($currenciesCondStr == "") {
            \str_replace("#currenciesCondStr#", "", $sql);
        }
        else {
            \str_replace("#currenciesCondStr#", " AND rates.currency_id IN (" .$currenciesCondStr . ")", $sql);
        }

        return $sql;
    }
}
