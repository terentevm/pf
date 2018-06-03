<?php

namespace app\Models;

use tm\Model;
use tm\Mapper;
use tm\rates\LoaderFabric;
use app\Models\Currency;
use tm\Registry as Reg;
use app\Models\DocumentCollection;
use app\Models\RateRecord;

class Rates extends Model
{
    private $dataset = null;

    public function getDataset()
    {
        return $this->dataset;
    }
    
    public function setDataset(array $dataset)
    {
        $this->dataset = new DocumentCollection($this);

        foreach ($dataset as $row) {
           
             $record = new RateRecord();
             $record->load($row);
             $this->dataset->add($record);
             
         }
    }

    public function addRecord(RateRecord $record)
    {
        if (is_null($this->dataset)) {
            $this->dataset = new DocumentCollection($this);   
        }

        $this->dataset->add($record);

    }

    public function loadRates(array $currencies, string $date1, string $date2)
    {
        $user_id = Reg::$app->user_id;
        
        list($inCondition, $params) = Mapper::in($currencies, "curr");
        
        $params['user_id'] = $user_id;
                
        $curr_arr = Currency::find()->where(["user_id = :user_id", "id IN (" . $inCondition . ")"])->setParams($params)->asArray()->all();
        
        
        $loader = LoaderFabric::getLoader();

        foreach ($curr_arr as $currency) {
            
            if(Currency::isSystemCurrency($currency['short_name'])) {
                $rates_data = [
                    'code' => $currency['short_name'],
                    'mult' => 1,
                    'rates' => [
                        strtotime("1980-01-01") => [ 'date' => "1980-01-01", 'rate' => 1 ]
                    ]
                ];     
            }
            else {
                $rates_data = $loader->load($currency['short_name'], $date1, $date2);    
            }
            

            if (empty($rates_data)) {
                continue;
            }

            $rates = $rates_data['rates'];
            
            $rates_db = $this->getExistsRates($currency['id'], $date1, $date2);
            
            $dataset = [];

            foreach ($rates as $date => $rate) {
                if (!$this->rateExists($rates_db, $date)) {
                    $dataset[] = [
                        'userId' => $user_id,
                        'currencyId' => $currency['id'],
                        'date' => $rate['date'],
                        'dateInt' => strtotime($rate['date']),
                        'mult' =>  $rates_data['mult'],
                        'rate' => $rate['rate'],
                    ] ;
                    
                }
            }
            
            if (empty($dataset)) {
                $ok = true;
                continue;
            }

            $this->setDataset($dataset);
        
            $ok = $this->save();
        }

       

        return $ok;
    }

    private function getExistsRates($currency_id, $date1, $date2)
    {
        $date1_int = strtotime($date1);
        $date2_int = strtotime($date2);
        $user_id = Reg::$app->user_id;
        $params = [
            'user_id' => $user_id,
            'currency_id' => $currency_id,
            'date1' => $date1_int,
            'date2' => $date2_int,
        ];

        $exist_rates = static::find()->where(['user_id = :user_id', "currency_id = :currency_id" ,'dateInt >= :date1', 'dateInt <= :date2'])->setParams($params)->asArray()->all();

        return $exist_rates;
    }

    private function rateExists($rates_db, $dateInt)
    {
        foreach ($rates_db as $record) {
            if ($record['dateInt'] == $dateInt) {
                return true;
            }
        }

        return false;
    }
}
