<?php
/**
 * Created by PhpStorm.
 * User: zaich
 * Date: 13.04.2019
 * Time: 21:51
 */

namespace tm\rates;


class ECBLoader implements IRatesLoader
{private $currencyCode;
    private $date1;
    private $date2;

    private $url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist.zip';

    private $data = [];

    public function load(string $currencyCode, string $date1, string $date2)
    {
        if (empty($this->data)) {
            $this->data = $this->makeRequest();
        }
    }

    private function makeRequest()
    {
        $tempFile = tempnam ( sys_get_temp_dir(), 'rates');
        
        if ($tempFile === false) {
            throw new Exception("Can't create temp file! ", 4);
        }
        $stream_context = stream_context_create([ 'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
            'verify_depth'      => 0 ]]);

        file_put_contents($tempFile, file_get_contents($this->url, null, $stream_context));
        
        if (($handle = fopen('zip://' . $tempFile . '#eurofxref-hist.csv', 'r')) !== FALSE) {
            
            $header = [];
            $index = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($index === 0) {
                    $header = $data;
                    $index++;
                    continue;
                }

                $rates = [];

                for ($i = 1; $i< count($header); $i++){
                    $rate = floatval($data[$i]);
                    $rates[$header[$i]] = $rate;
                }

                $this->data[$data[0]] = $rates;
                $index++;
            }

            fclose($handle);
        }    

        unlink($tempFile);

        print_r($this->data);
    }
}