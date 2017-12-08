<?php

namespace tm;

abstract class Base
{
    public static function className(){
        return get_called_class();
    }
}