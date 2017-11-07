<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use Base\Model;
/**
 * Description of ProgramSettings
 *
 * @author terentyev.m
 */
class ProgramSettings extends Model {
    public $table = 'view_program_settings';
    
    public $attributes = [
        'user_id' => '',
        'main_currency_id',
        'main_currency_name',
        'sys_currency_id',
        'sys_currency_name',
        'central_bank'
    ];
}
