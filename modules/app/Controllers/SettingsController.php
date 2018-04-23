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
        
        return $this->createResponse($str_json, $httpcode);
    }
}
