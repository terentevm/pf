<?php

namespace tm;

abstract class Base
{
    public static function className(){
        return get_called_class();
    }
    
    public function debug($arr){
        echo '<pre>' .print_r($arr,true).'</pre>';
    }
}