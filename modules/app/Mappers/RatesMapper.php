<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class RatesMapper extends Mapper
{
    public static $db_columnes = ['id', 'user_id','date','dateInt', 'currency_id' , 'mult', 'rate'];

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
            $sql = $this->qb->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }

        $dataset = $obj->getDataset();

        if (is_null($dataset)) {
            return false;
        }

        foreach ($dataset->strings() as $record) {
            
            $params = $this->mapModelToDb($record);
            $success = $this->create_stmt->execute($params);
            if ($success !== true) {
                return false;
            }
        }
        
        return true;
    }
    
    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => null,
            'user_id' => $obj->getUserId(),
            'date' => $obj->getDate(),
            'dateInt' => $obj->getDateInt(),
            'currency_id' => $obj->getCurrencyId(),
            'mult' => $obj->getMult(),
            'rate' => $obj->getRate()
        ];
        
        return $db_arr;
    }

    public function getLastRates(string $userId, int $dateInt, $currencies = [])
    {
        $params = [
            "usedId" => $userId,
            "dateInt" => $dateInt
        ];

        if (count($currencies) > 0) {
            list($paramString, $params) = $this->qb->createParamStringFromArray($currencies);

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
                $result_accoc[$record['currId']] = [
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
        ratesByDate.currId,
        ratesByDate.maxDate,
        reg.rate,
        reg.mult
        FROM 
        (SELECT 
            rates.currency_id as currId,
            MAX(rates.dateInt) as maxDate
            FROM rates WHERE user_id = :usedId AND rates.dateInt < :dateInt #currenciesCondStr#
        GROUP BY
            rates.currency_id) as ratesByDate
        LEFT JOIN rates as reg on ratesByDate.currId = reg.currency_id AND ratesByDate.maxDate = reg.dateInt";

        if ($currenciesCondStr == "") {
            \str_replace("#currenciesCondStr#", "", $sql);
        }
        else {
            \str_replace("#currenciesCondStr#", " AND rates.currency_id IN (" .$currenciesCondStr . ")", $sql);
        }

        return $sql;
    }
}
