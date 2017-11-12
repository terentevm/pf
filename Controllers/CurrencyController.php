<?php

namespace Controllers;

use Base\Controller;
use Models\Currency;
use Base\Validator as my_validator;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class CurrencyController extends Controller
{
    private $limit = 50;
    private $offset = 0;

    public function actionGetList(){
        
        $this->view = 'currency_list';

        $this->GetView();
    }
    public function actionGetListData(){
        
        $this->view = 'currency_list_data';

        if(isset($_POST['offset'])){
            $this->offset = ( int )$_POST['offset'];
        }
      
        $dic_elements = Currency::find('id, code, name, short_name')->where(['user_id', '=', $_SESSION['user_id']])->limit($this->limit, $this->offset)->selectAll();
        $this->vars = $dic_elements;
        $this->GetView();
    }
    
    public function actionGetElement(){
       
        $this->view = 'currency_element';
		
        if (isset($_POST['id'])){
           /*$is_id = my_validator::uiid($_POST['id']);

            if(!$is_id){
                header('HTTP/1.1 400 Bad Request');
                header('Content-Type: application/text; charset=UTF-8');
                die("Incorrect id format");
            }*/
			
            $dic_element = Currency::find()->where(['id', '=', $_POST['id']])->limit(1)->selectAll();
            
            if (empty($dic_element)){
                header(http_response_code(404));
                header('Content-Type: application/text; charset=UTF-8');
                die("element not found by id");   
            }

			$this->vars = $dic_element;
            
            $this->GetView();
            exit();

        }
		
        $this->vars = [];
        //get form of new element
        $this->GetView();

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