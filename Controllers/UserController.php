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
             
            
            $success = User::verify($login, $password);
            
            if(!$success){
                $this->errors[] = 'Invalid login or password';
                $this->getErrors();
                $this->GetView();
                
                exit();   
            }
            
            $user->StartSession();
            
            $_SESSION['success'] = true;
            header('Location: /site/index');
        }
        else{
            $this->GetView();
        }
    }

    public function actionLogout(){
        $user = new User();
        $user->Load(['id' => $_SESSION['user_id']]);
        $user->Logout();
        
        session_destroy();
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
                $this->vars = $formData;
                $this->GetView();
                exit();
            }
            
            //проверяем уникальноть логина.
            
            
            
            if(!$user->CheckUnique()){
                //выводим вид вместе с ошибкой
                $this->errors[] = 'Login already taken';
                $this->getErrors();
                $this->GetView();
                
                exit();
                
            }
            
            //Create new user and redirect to login page
           
            $success = $user->save();

            if(!$success){
                $this->errors[] = 'Error, please try again!';
                $this->getErrors();
                $this->GetView();
                
                exit();    
           }
           
           header('Location: /user/login');
        }
        else{
            $this->GetView();
        }
    }
}