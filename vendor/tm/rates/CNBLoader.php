<?php

namespace tm\rates;

use tm\rates\IRatesLoader;

class CNBLoader implements IRatesLoader
{
    private $currencyCode;
    private $date1;
    private $date2;

    private $url = "http://www.cnb.cz/miranda2/m2/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/vybrane.txt";
    

    public function load(string $currencyCode, string $date1, string $date2) : array
    {
        $this->currencyCode = $currencyCode;
        $this->date1 = new \DateTime($date1);
        $this->date2 = new \DateTime($date2);

        if ($this->date1 > $this->date2) {
            return [];
        }
        
        $result = $this->makeRequest($currencyCode);
        $result_arr = $this->parseData($result, $currencyCode);
        
        return $result_arr;
    }

    private function makeRequest($currencyCode)
    {
        $fullUrl = $this->url . $this->createParamString($currencyCode);
       
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_URL, $fullUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result= curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    private function createParamString($currencyCode)
    {
        $mena = "mena=" . $currencyCode;
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
            return [];
        }
        $result = [
            'code' => $currencyCode,
            'mult' => $mult,
        ];

        $rates = [];

        for ($i = 2; $i < count($rows); $i++) {
            $row_str = $rows[$i];

            if (empty($row_str)) {
                continue;
            }

            $parts = explode("|", $row_str);

            $date_fmt = (new \DateTime(trim($parts[0])))->format("Y-m-d");
            $dateInt = strtotime($date_fmt);
            $rates[$dateInt] =  [
                'date' => $date_fmt,
                'rate' => floatval(str_replace(",", ".", $parts[1]))
            ];
        }
        
        $result['rates'] = $rates;
        
        return $result;
    }
}
