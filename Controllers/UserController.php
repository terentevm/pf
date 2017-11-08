<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;
use Base\Controller;
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
    
    public $layout = 'main';
    
    public function actionLogin(){
        
        if(isset($_POST) && !empty($_POST)){
        
            $formData = filter_input_array(
                INPUT_POST,
                [
                    'login' => FILTER_SANITIZE_EMAIL,
                    'password' => FILTER_DEFAULT
                ],
                true
            );
        
            $validator = v::attribute('login', v::stringType()->notEmpty()->email())
            ->attribute('password', v::stringType()->notEmpty());

            $user = new User();
            $user->Load($formData);

            try{
                $validator->assert($user);
            } catch (ValidationException $exception) {
                $this->errors = $exception->getMessages();
                $this->getErrors();
                $this->vars = $formData;
                $this->GetView();
                exit();
            }
            
            $AuthData = $user->CheckAuthData();
            
            if(!$AuthData['success']){
                $this->errors[] = 'Invalid login or password';
                $this->getErrors();
                $this->GetView();
                
                exit();   
            }
            
            $user->StartSession(['user_agent' => $_SERVER['HTTP_USER_AGENT']]);
            
            $_SESSION['success'] = TRUE;
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
        
        unset($_SESSION['success']);
        unset($_SESSION['user_id']);
        
        setcookie('hash','',time()-3600);
        
        session_destroy();
        header('Location: /user/login');
    }
    
    public function actionSignup(){
        
        if(isset($_POST) && !empty($_POST)){
        
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
            $user->Load($formData);

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
           if(!$user->CreateNewUser()){
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