<?php

namespace app\Controllers;

use tm\RestController;

use app\Models\Settings;
use app\Models\Currency;

class SettingsController extends RestController
{
    public static $classModel = '\app\models\Settings';
    
    public function ActionCurrencyClassificator() {
        $str_json = Currency::getClassificator();
        
        $httpcode = is_null($str_json) ? 404 : 200;
        $success = is_null($str_json) ? false : true;
        $msg = is_null($str_json) ? "Classificator is not found" : "OK";
       
        return $this->createResponse($this->createResponseData($success, $str_json, $msg), $httpcode);
    }
}
