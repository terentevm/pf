<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controllers;

use tm\Controller;

use tm\Registry as Reg;
use app\Models\User;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Exceptions\NestedValidationException;
/**
 * Description of User
 *
 * @author terentyev.m
 */
class UserController extends Controller 
{
    
    public $layout = 'material';
    
    public static $defaultAction = 'actionLogin';


    public function actionLogin(){
        
        $post = Reg::$app->request->post();

        if(!empty($post)){
            
            $login = $post['login'] ?? '';
            $password = $post['password'] ?? '';
            
            $user_id = User::verify($login, $password);
            
            if($user_id === false){
               
                $inputed_data = [
                    'login' => \filter_var($login, FILTER_SANITIZE_EMAIL)
                ];
                
                return $this->createResponse($this->createResponseData('Invalid login or password!', $inputed_data), 401);  
            }
            
            if (Reg::$app->config->useSessions()) {
                Reg::$app->startSession(['user_id' => $user_id]);
                header('Location: /site/index');
                die();
            }
            
            $token = Reg::$app->access_manager->generateNewToken($user_id);
            setcookie("jwt", $token, time() + 80000);

            return $this->createResponse(['jwt' => $token], 200);
            
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
            
            $user = new User();
            
            $user->loadSafe($post);
 
            $ok = $user->validate();
            
            
            $returnData =[
                'login' =>$user->getLogin(),
                'name' =>$user->getName(), 
            ];

            if ($ok !== true) {
                
                return $this->createResponse($this->createResponseData('Inputed data are invalid!', $returnData), 400);    
            }
            
            $user->hashPassword();
            
            //check login unique.        
            
            if(!$user->CheckUnique()){
              
                return $this->createResponse($this->createResponseData('Login already taken', $returnData), 400);      
            }
            
            
            //save new user
           
            $success = $user->save();

            if(!$success){

                return $this->createResponse($this->createResponseData("Server error", $returnData), 500, 'Error, please try again!');
           }
           
           //if data are saved, create response with code 200

           return $this->createResponse($this->createResponseData("User has been registered successful!"), 201);

           //redirect to login page
           //header('Location: /user/login');
        }
        else {
            // output registrqation form
            return $this->createResponse("OK", 200);
        }
    }
    
    public function actionDelete() {
        $post = Reg::$app->request->post();
        
        if (!empty($post) && isset($post['login'])) {
        
            $login = \filter_var($post['login'], FILTER_SANITIZE_EMAIL);
            
            $user = User::find()->where(['login = :login'])->setParams(['login' => $login])->limit(1)->one();
            
            if (is_object($user) && $user instanceof User) {
                $delited = $user->delete();
                
                if ($delited === true) {
                    return $this->createResponse("User has been deleted successfully!", 200);    
                }
                
                return $this->createResponse("error", 400); 
            }
        }
        return $this->createResponse("Login hasn't been transfered! Delete field!", 400);    
        
    }

    private function createResponseData($msg, $returnData =[]) {
        return [
            'msg' => $msg,
            'formData' => $returnData
        ];
    }
}