<?php

namespace app\Models;

use tm\Model;
use tm\Mapper;
use tm\rates\LoaderFabric;
use app\Models\Currency;
use tm\Registry as Reg;
use app\Mappers\RatesMapper;

class Rates extends Model
{
    private $dataset =[];

    public function getDataset()
    {
        return $this->dataset;
    }
    
    public function setDataset(array $dataset)
    {
        $this->dataset = $dataset;
    }

    public function loadRates(array $currencies, string $date1, string $date2)
    {

        $user_id = Reg::$app->user_id;
        
        list($inCondition, $params) = Mapper::in($currencies, "curr");
        
        $params['user_id'] = $user_id;
                
        $curr_arr = Currency::find()->where(["user_id = :user_id", "id IN (" . $inCondition . ")"])->setParams($params)->asArray()->all();
        
        
        $loader = LoaderFabric::getLoader();

        foreach ($curr_arr as $currency) {
            
            $rates_data = $loader->load($currency['short_name'], $date1, $date2);

            if (empty($rates_data)) {
                continue;
            }

            $rates = $rates_data['rates'];
            
            $rates_db = $this->getExistsRates($currency['id'], $date1, $date2);
            
            foreach ($rates as $date => $rate) {
                if (!$this->rateExists($rates_db, $date)) {
                    $record = [
                        'user_id' => $user_id,
                        'currency_id' => $currency['id'],
                        'date' => $rate['date'],
                        'mult' =>  $rates_data['mult'],
                        'rate' => $rate['rate'],
                    ] ; 
                    
                    array_push($this->dataset, $record);
                    
                }
            }

        }

        if (empty($this->dataset)){
            return true;
        }

        $mapper = new RatesMapper(get_class($this));
        $ok = $mapper->save($this);

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

    private function rateExists($rates_db, $dateInt) {
        foreach($rates_db as $record) {
            if ($record['dateInt'] == $dateInt) {
                return true;
            }
        }

        return false;
    }
}