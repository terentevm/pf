<?php

namespace app\Controllers;

use tm\RestController;
use app\Models\Currency;
use app\Models\Rates;

use tm\Registry;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class CurrencyController extends RestController
{
 
    public static $classModel = '\app\models\Currency';
   
    public function actionLoad()
    {
        $post = Reg::$app->request->post();
        
        $errors = [];
        if (!isset($post['currencies']) || empty($post['currencies'])) {
            $errors[] = "currencies array isn't set or empty";
        }

        if (!isset($post['dateFrom']) || empty('dateFrom')) {
            $errors[] = "begin date isn't set or empty";
        }

        if (!isset($post['dateTo']) || empty('dateTo')) {
            $errors[] = "End date isn't set or empty";
        }

        if (!empty($errors)) {
            return $this->createResponse($errors, 500); 
        }

        

    }
}