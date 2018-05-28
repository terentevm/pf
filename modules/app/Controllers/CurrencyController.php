<?php

namespace app\Controllers;

use tm\RestController;
use app\Models\Currency;
use app\Models\Rates;

use tm\Registry as Reg;
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
        
        $rates = new Rates();
        $result = $rates->loadRates($post['currencies'], $post['dateFrom'], $post['dateTo']);
        
        if ($result === true) {
            return $this->createResponse($this->createResponseData(true, ["Currency rates have been loaded"], ""), 201);
        } else {
            return $this->createResponse($this->createResponseData(false, ["Currency rates have not been loaded"], ""), 500);
        }
    }
}
