<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;
use tm\Controller;
use tm\Registry as Reg;
use Models\User;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;
/**
 * Description of User
 *
 * @author terentyev.m
 */
class UserController extends Controller {
    
    public $layout = 'material';
    
    public static $defaultAction = 'actionLogin';


    public function actionLogin(){
        
        $post = Reg::$app->request->post();

        if(!empty($post)){
            
            $login = $post['login'];
            $password = $post['password'];
            /**
             * Here must be validations actions
             */
             
            
            $user_id = User::verify($login, $password);
            
            if($user_id === false){
                $this->errors[] = 'Invalid login or password';
                $this->getErrors();
                
                $inputed_data = [
                    'login' => \htmlspecialchars($login)
                ];
                
                return $this->createResponse($inputed_data, 401, '');  
            }
            
            Reg::$app->startSession(['user_id' => $user_id]);
    
            header('Location: /site/index');
        }
        else{
            return $this->createResponse(null, 200, '');
        }
    }

    public function actionLogout(){
        
        Reg::$app->endSession();
        header('Location: /user/login');
        
    }
    
    public function actionSignup(){
        $post = Reg::$app->request->post();

        if(!empty($post)){
        
            $formData = filter_input_array(
                INPUT_POST,
                [
                    'login' => FILTER_SANITIZE_EMAIL,
                    'name' => FILTER_SANITIZE_STRING,
                    'password' => FILTER_DEFAULT
                ]
            );
            
            $inputed_data = [
                'login' => \htmlspecialchars($formData['login']),
                'name' => \htmlspecialchars($formData['name'])
            ];


            $validator = v::attribute('login', v::stringType()->notEmpty()->email())
            ->attribute('name', v::stringType()->notEmpty())
            ->attribute('password', v::stringType()->notEmpty());

            $user = new User();
            $user->load($formData);
            $user->hashPassword();

            try{
                $validator->assert($user);
            } catch (ValidationException $exception) {
                $this->errors = $exception->getMessages();
                $this->getErrors();
                
                return $this->createResponse("$inputed_data", 400, 'Inputed data are invalid!');
            }
            
            //check login unique.        
            
            if(!$user->CheckUnique()){
                //output error
                $this->errors[] = 'Login already taken';
                $this->getErrors();
                return $this->createResponse($inputed_data, 400, 'Login already taken');      
            }
            
            //Create new user and redirect to login page
           
            $success = $user->save();

            if(!$success){
                $this->errors[] = 'Error, please try again!';
                $this->getErrors();
                return $this->createResponse($inputed_data, 500, 'Error, please try again!');
           }
           
           //if data are saved, create response with code 200

           return $this->createResponse("User has been registered successful!", 200);

           //redirect to login page
           //header('Location: /user/login');
        }
        else {
            // output registrqation form
            return $this->createResponse("OK", 200);
        }
    }
}