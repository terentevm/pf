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

    public static $filter = [
        'trim' => 'trim_value',
        'toEmail' => 'toEmail',
        'toInt' => 'toInt',
        'toString' => 'toString',
    ];
    public static $validator = [
        'email' => 'isEmail',
        'id' => 'isId',
    ];

    /**
     * Description of function filterdata
     * @inputData - is can be some of superglobals like $_POST, $_GET etc. or associative array
     * rules - associative array [property, rules[rule1, rule2 ...]]
     * 
     * function returns associative array with elements equal input data
    */
    public static function filterData($inputData, $rules = []){
        $errors = [];
        $return_array = [];

        foreach ($inputData as $property =>$property_value){
            if (!array_key_exists( $property , $rules )){
            continue;
            }
            
            $property_rules = $rules[$property];
            
            foreach($property_rules as $rule){
                $func = self::getFilter($rule);
                
                $correct = self::$func($property_value);
                
                if (!$correct){
                    $errors[] = $correct;   
                }
            }
            
        }
    }

    public static function validate($inputData, $rules = []){
        $errors = [];
        foreach ($inputData as $property =>$property_value){
            if (!array_key_exists( $property , $rules )){
            continue;
            }
            
            $property_rules = $rules[$property];
            
            foreach($property_rules as $rule){
                $validator = self::getValidator($rule);
                
                $correct = self::$validator($property_value);
                
                if (!$correct){
                    $errors[] = $correct;   
                }
            }
            
        }
        
        return $errors;
    }
    

    public static function getValidator($rule){
        return self::$validator[$rule];
    }
    
    public static function getFilter($rule){
        return self::$filter[$rule];
    }

    public static function trim_value(&$value){
        trim($value);  
    }
    
    public static function to_Email(&$value){
        filter_var($value, FILTER_SANITIZE_EMAIL);  
    }
    
    public static function to_Int(&$value){
        filter_var($value, FILTER_SANITIZE_EMAIL);  
    }

    public static function isId($value){
        if (preg_match("/^[a-z0-9-]{0,36}$/", $value)){
            return true;
        }
        
        return 'id is incorrect!';
    }
    
    public static function isEmail($value){
       if (filter_var($value, FILTER_VALIDATE_EMAIL)){
           return true;
       }
       
       return 'email is incorrect';
        
    }

    public static function toInt($value){
        if (filter_var($value, FILTER_VALIDATE_INT)){
            return true;
        }
        


    }
}
