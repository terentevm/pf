<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;

use tm\Model;

/**
 * Description of tools
 *
 * @author terentyev.m
 */
class Tools extends Model
{
    public $attributes = ['import_files' => []];
    
    public function ImportDataFrom1c()
    {
        $import_files = $this->attributes['import_files'];
        
        foreach ($import_files as $file) {
            $filename = $file['filename'];
            $json_str = $file['json_str'];
            $data = json_decode($json_str);
            if (!is_array($data)) {
                return false;
            }
            $dic_class_name = '';
            
            if ($filename == 'spr_currency.json') {
                $dic_class_name = "Models". "\\" .'Currency';
            } elseif ($filename == 'spr_wallets.json') {
                $dic_class_name = "Models". "\\" . 'Wallets';
            } elseif ($filename == 'spr_items_income.json') {
                $dic_class_name = "Models". "\\" . 'ItemsIncome';
            } elseif ($filename == 'spr_items_expenditure.json') {
                $dic_class_name = "Models". "\\" . 'ItemsExpenditure';
            } else {
                continue;
            }
            

            $IsErrors = false;
            
            if (class_exists($dic_class_name)) {
                foreach ($data as $obj) {
                    $arr_elements = get_object_vars($obj);
                    
                    $DicObject = new $dic_class_name();
                    $DicObject->load($arr_elements);
                    $success = $DicObject->SaveOrUpdate();
                    if (!$success == true) {
                        $IsErrors = true;
                        break;
                    }
                }
                
                if ($IsErrors) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }
}
