<?php

namespace app\Models;

use tm\Model;

use tm\rates\LoaderFabric;
use app\Models\Currency;
use tm\Registry as Reg;
use tm\Mappers\RatesMapper;

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

    public function loadRates(array $currencies, string $date1, sting $date2)
    {

        $user_id = Reg::$app->user_id;

        $params = [
            'user_id' => $user_id,
            'currency_arr' => implode(",", $currencies)
        ];
        
        $curr_arr = Currencies::find()->where(["user_id = :user_id", "id IN (:currency_arr)"])->setParams($params)->asArray()->all();
        
        
        $loader = LoaderFabric::getLoader();

        foreach ($curr_arr as $currency) {
            
            $rates_data = $loader->load($currency['short_name'], $data1, $data2);

            if (empty($rates_data)) {
                continue;
            }

            $rates = $rates_data['rates'];
            
            $rates_db = getExistsRates($currency['id'], $date1, $date2);
            
            foreach ($rates as $date => $rate) {
                if (!$this->rateExists($rates_db, $date)) {
                    $record = [
                        'currency_id' => $currency['id'],
                        'date' => $rate['date'],
                        'mult' =>  $rates_data['mult'],
                        'rate' => $rate['rate'],
                    ] ; 
                    
                    $this->dataset.push($record);

                }
            }

        }

        if (empty($this->dataset)){
            return false;
        }

        $mapper = new RatesMapper();
        $ok = $mapper->save($this);

        return $ok;
      
    }

    private function getExistsRates($currency_id, $date1, $date2)
    {
        $date1_int = strtotime($date1);
        $date2_int = strtotime($date2);
        
        $params = [
            'user_id' => $user_id,
            'currency_id' => $currency_id,
            'date1' => $date1_int,
            'date2' => $date2_int,
        ];

        $exist_rates = static::find()->where(['user_id = :user_id', "currency_id = :currency_id" ,'date_int >= :date1', 'date_int <= :date2'])->setParams($params)->asArray()->all();

        return $exist_rates;

    }

    private function rateExists($rates_db, $dateInt) {
        foreach($rates_db as $record) {
            if ($record['dateInt'] === $dateInt) {
                return true;
            }
        }

        return false;
    }
}