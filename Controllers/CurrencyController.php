<?php

namespace Controllers;

use tm\RestController;
use Models\Currency;
use tm\Registry;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class CurrencyController extends RestController
{
    private $limit = 50;
    private $offset = 0;
    
    public static $classModel = '\models\Currency';
    
    /*public function actionCreate(){
        
        $post = Registry::$app->post();
        
        if (!empty($post)) {
            return $this->createResponse("No data for save", 400, '');
        }
        
        $filters = [
            'code' => FILTER_SANITIZE_STRING,
            'name' => FILTER_SANITIZE_STRING,
            'short_name' => FILTER_SANITIZE_STRING
            ];
        
        $inputData = filter_var_array($post, $filters);
        
        if ($inputData === false || is_null($inputData)) {
            return $this->createResponse("Data consists errors", 400, '');   
        }
        
        $validator = v::attribute('code', v::stringType()->notEmpty())
                    ->attribute('name', v::stringType()->notEmpty())
                    ->attribute('short_name', v::stringType()->notEmpty());

        $currency = new Currency();
        
        foreach ($inputData as $key => $value) {
            $currency->$key = $value;  
        }
        
        try{
            $validator->assert($currency);
        } catch (ValidationException $exception) {

            $errors = $exception->getMessages();
            
            header(http_response_code(500));
            
            $this->errors = $errors;
            
            $this->getErrors();
            
            if ($_SESSION[isAjax]){
                echo $_SESSION['error'];
                exit();
            }
            $this->vars[] = $inputData;
            $this->GetView();
            
        }
        
	
        $success = $currency->save();
		
		if($success === true) {
			header(http_response_code(200));
			echo "success";
		}
		else {
			header(http_response_code(500));	
		}
        
    }*/

}