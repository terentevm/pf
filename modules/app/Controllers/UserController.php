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
use app\Models\Settings;
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

            $token = Reg::$app->access_manager->generateNewToken($user_id);
            
            $oSettings = Settings::getSettings($user_id);
            
            $data = [
                'jwt' => $token,
                'settings' => $oSettings
            ];

            return $this->createResponse($data, 200);
            
        }
        else{
            return $this->createResponse(null, 200, '');
        }
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
    
    public function changePassword()
    {
        $post = Reg::$app->request->post();
        
        if (empty($post)) {
            return $this->createResponse(['result' => false, 'msg' => "No data!"], 500);    
        }

        //For change password user should be authorised.

        if (is_null(Reg::$app->user_id)) {
            return $this->createResponse(['result' => false, 'msg' => "Not authorise!"], 401);    
        }

        $user = User::findById(Reg::$app->user_id, false);

        if (!$user instanceof User) {
            return $this->createResponse(['result' => false, 'msg' => "Error get user!"], 500);     
        }
        
        $currentPasword = $post['currentPasword'] ?? '';

        if ($user->verifyPassword($currentPasword) !== true) {
            return $this->createResponse(['result' => false, 'msg' => "Current password is invalid!"], 500);   
        }

        $newPassword = $post['newPassword'] ?? '';
        $user->setPassword($newPassword);
        $ok = $user->validate();

        if (!$ok === true) {
            return $this->createResponse(['result' => false, 'msg' => "error validate data!"], 500);     
        }
        
        $user->hashPassword();

        $updated = $user->update();

        if ($updated === true) {
            return $this->createResponse(['result' => true, 'msg' => "Password has been updated"], 200);   
        }
        else {
            return $this->createResponse(['result' => false, 'msg' => "Password hasn't been updated"], 500);
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