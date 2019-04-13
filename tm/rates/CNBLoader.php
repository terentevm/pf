<?php

namespace tm\rates;

use tm\rates\IRatesLoader;

class CNBLoader implements IRatesLoader
{
    private $currencyCode;
    private $date1;
    private $date2;

    private $url = "http://www.cnb.cz/miranda2/m2/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/vybrane.txt";
    

    public function load(string $currencyCode, string $date1, string $date2) : RateData
    {
        $this->currencyCode = $currencyCode;
        $this->date1 = new \DateTime($date1);
        $this->date2 = new \DateTime($date2);

        if ($this->date1 > $this->date2) {
            throw new RatesLoaderException("Invalid parameters passed. Date 2 must be more then date 1",2);
        }
        
        $result = $this->makeRequest($currencyCode);
        $rate_data = $this->parseData($result, $currencyCode);
        
        return $rate_data;
    }

    private function makeRequest($currencyCode)
    {
        $fullUrl = $this->url . $this->createParamString($currencyCode);
       
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_URL, $fullUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result= curl_exec($curl);

        if(curl_errno($curl)){
            throw new RatesLoaderException('Request Error:' . curl_error($curl),3);
        }

        curl_close($curl);

        return $result;
    }

    private function createParamString($currencyCode)
    {
        $mena = "mena=" . trim($currencyCode);
        $od = "od=" . $this->date1->format("d.m.Y");
        $do = "do=" . $this->date2->format("d.m.Y");

        $params = "?" . implode("&", array($mena, $od, $do));

        return $params;
    }

    private function parseData(string $data_txt, $currencyCode)
    {
        $rows = explode("\n", $data_txt);

        $headers = explode("|", $rows[0]);

        $parts_mult = explode(":", $headers[1]);
        $mult = intval($parts_mult[1]);
        
        if ($mult === -1) {
            throw new RatesLoaderException("Parsing error for currency code: " . $currencyCode,1);
        }

        $rate_data = new RateData($currencyCode, $mult);

        for ($i = 2; $i < count($rows); $i++) {
            $row_str = $rows[$i];

            if (empty($row_str)) {
                continue;
            }

            $parts = explode("|", $row_str);

            $date_fmt = (new \DateTime(trim($parts[0])))->format("Y-m-d");

            $rate_data->addRate($date_fmt, floatval(str_replace(",", ".", $parts[1])));

        }

        
        return $rate_data;
    }
}
