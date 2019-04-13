<?php

namespace tm\rates;

use tm\rates\CNBLoader;

class LoaderFabric
{
    public static function getLoader($code)
    {
        switch ($code){
            case 'CZK':
                return new CNBLoader();
                break;
            case 'EUR':
                return new ECBLoader();
                break;
            default:
                return null;

        }
    }
}
