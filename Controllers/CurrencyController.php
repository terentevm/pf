<?php

namespace Controllers;

use tm\RestController;
use Models\Currency;
use tm\Registry;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class CurrencyController extends RestController
{
 
    public static $classModel = '\models\Currency';
   

}