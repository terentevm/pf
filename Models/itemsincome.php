<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;
use tm\Model;
use tm\TraitModelFunc;
/**
 * Description of itemsincome
 *
 * @author terentyev.m
 */
class Itemsincome extends Model {
    
    public $table = 'dic_items_income';
    use TraitModelFunc;
    
    public $attributes = [
        'id' => '',
        'name' => '',
        'user_id' => '',
        'not_active' => 0,
        'comment' => '',
        'parent_id' => NULL
    ];
}
