<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;

use tm\RestController;
use tm\Validator;
use Models\Wallets;
use Models\Currency;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;
/**
 * Description of WalletsController
 *
 * @author terentyev.m
 */
class WalletsController extends RestController
{
    
    public static $classModel = '\models\Wallet';
    
}
