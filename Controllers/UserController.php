<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;
use Base\Controller;
use Models\User;
/**
 * Description of User
 *
 * @author terentyev.m
 */
class UserController extends Controller {
    
    public $layout = 'main';
    
    public function actionLogin(){
        if(isset($_POST) && !empty($_POST)){
        
            $rules = [
                'required' => [
                'password',
                'email'
                
                ],
                'email' => [
                'email'
            ]
            ];
        
            $data = $_POST;
            
            //если данные не валидированы, то выводим вид вместе с сообщением
            
            if(!$this->validate($data, $rules)){
                $this->getErrors();
                $this->GetView();
                exit();
            }
            
            //проверяем введенные данные
            
            $user = new User();
            $user->Load($data);
            
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
        
            $rules = [
                'required' => [
                'password',
                'email',
                'name',
                ],
                'email' => [
                'email',
            ]
            ];
        
            $data = $_POST;
            
            //если данные не валидированы, то выводим вид вместе с сообщением
            
            if(!$this->validate($data, $rules)){
                $this->getErrors();
                $this->GetView();
                exit();
            }
            
            //проверяем уникальноть логина.
            
            $user = new User();
            $user->Load($data);
            
            if(!$user->CheckUnique()){
                //выводим вид вместе с ошибкой
                $this->errors[] = 'Login already taken';
                $this->getErrors();
                $this->GetView();
                
                exit();
                
            }
            
            //создаем нового пользователя и переадресуем на страницу входа.
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