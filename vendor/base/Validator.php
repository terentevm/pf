<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Base;

/**
 * Description of Validator
 *
 * @author terentyev.m
 */
class Validator {

    public static function uiid(&$value) {
        
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
        $success = \preg_match($pattern, $value);
        return $success;
    }
    
    public static function filterCheckBox(&$value) {
        
        if ($value === null) {
            $value = 0;
            return $value;
        }
        
        $value = 1;
        
        return $value;
    }
    
    
}
