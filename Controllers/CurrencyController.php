<?php

namespace Controllers;

use tm\Controller;
use Models\Currency;
use tm\Registry;
use tm\Validator as my_validator;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class CurrencyController extends Controller
{
    private $limit = 50;
    private $offset = 0;

    public function actionGetList(){
        
        $this->view = 'currency_list';

        return $this->createResponse();
    }
    
    public function actionGetListData(){
        
        $this->view = 'currency_list_data';

        $post = Registry::$app->request->post();

        if(isset($post['offset'])){
            $this->offset = ( int )$post['offset'];
        }
      
        $dic_elements = Currency::findByUser($_SESSION['user_id'], $this->limit, $this->offset);
        
        return $this->createResponse($dic_elements);

    }
    
    public function actionGetElement(){
        
        $post = Registry::$app->request->post();

        $this->view = 'currency_element';
		
        if (isset($post['id'])){
			
            $dic_element = Currency::findById($post['id']);
            
            if (empty($dic_element)){
                return $this->createResponse(null, 404, 'Not found') ;
            }

			return $this->createResponse($dic_element);

        }
		
        return $this->createResponse();

    }

    public function actionSaveElement(){

        $validator = v::attribute('code', v::stringType()->notEmpty())
                    ->attribute('name', v::stringType()->notEmpty())
                    ->attribute('short_name', v::stringType()->notEmpty());

        $inputData = filter_input_array(
            INPUT_POST,
            [
                'code' => FILTER_SANITIZE_STRING,
                'name' => FILTER_SANITIZE_STRING,
                'short_name' => FILTER_SANITIZE_STRING
            ]
        );
        $currency = new Currency();
        $currency->load($_POST);
        
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
        
    }

}