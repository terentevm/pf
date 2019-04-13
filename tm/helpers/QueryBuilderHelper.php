<?php

/**
 * Class QueryBuilderHelper contain helper methods for sql queries such as creating condition strings etc
 */

namespace tm\helpers;


class QueryBuilderHelper
{
    
    /**
     * inCondition
     * 
     * Creates IN condition string and array of paramters
     *
     * @param  string $colName Name of table field
     * @param  array $values array with  values
     * @param  mixed $prefix using as prefix for parametres ($prefix1, $prefix2...) 
     *
     * @return array contains param string and assoc array with param values
     */
    public static function inCondition(string $colName, array $values, $prefix = "val") : array
    {
        
        list($paramString, $arrParams) = self::createInParamString($values, $prefix);

        $inCondString = self::createTextInCondition($colName, $paramString);

        return array($inCondString, $arrParams);
        
    }

    /**
     * transforms filters array to text condition
     * condition string should be builded by createInParamString method of the this class
     * @param string col_name  name of column wich is contained in filter array
     * @param string condition string ":val1, :val2...."
     */
    public static function createTextInCondition(string $col_name, string $conditionStr): string
    {
    
        $cond_text = "{$col_name} IN (" . $conditionStr . ")";
        
        return $cond_text;
    }


    /**
     * createParamStringFromArray
     * creates a named parameters string for IN condition and an associative array with values of the parameters
     * 
     * @param  array(string) $values
     * @param  string $prefix
     *
     * @return array(string, array)
     */
    public static function createInParamString(array $values, string $prefix = "val") : array 
    {
        $length = count($values);
        
        $arr_param = [];
        $params = [];
        for ($i = 0; $i < $length; $i++) {
            $param_name = $prefix . $i;
            $param_name_to_str = ":" . $prefix . $i;
            array_push($arr_param, $param_name_to_str);
            $params[$param_name] = $values[$i];
        }
        
        $paramString = implode(",", $arr_param);
        
        return array($paramString, $params);
    }
}