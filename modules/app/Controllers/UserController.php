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


    public function actionLogin()
    {
        $post = $this->request->post();

        if (!empty($post)) {
            $login = $post['login'] ?? '';
            $password = $post['password'] ?? '';
            
            $user_id = User::verify($login, $password);
            
            if ($user_id === false) {
                $inputed_data = [
                    'login' => \filter_var($login, FILTER_SANITIZE_EMAIL)
                ];
                
                return $this->createResponse($this->createResponseData(false, $inputed_data, 'Invalid login or password!'), 401);
            }

            $ip = $this->request->getServerParam('REMOTE_ADDR', null);

            $auth = $this->container['AuthManager'];
            
            $token = $auth->generateNewToken(
                [
                    'user_id' => $user_id,
                    'ip' => $ip
                ]);
            
            $oSettings = Settings::getSettings($user_id);

            $data = [
                'jwt' => $token,
                'settings' => $oSettings
            ];

            return $this->createResponse($this->createResponseData(true, $data, "OK"), 200);
        } else {
            return $this->createResponse($this->createResponseData(false, null, "Login data hasn't ben recieved"), 200);
        }
    }

    public function actionSettings()
    {
        $method = $this->request->getMethod();

        if ($this->user_id === null) {
            return $this->createResponse($this->createResponseData(false, [], 'User is not authorized'), 401);
        }

        if ($method === 'GET') {
            $oSettings = Settings::getSettings($this->user_id);

            return $this->createResponse($this->createResponseData(true, $oSettings, "OK"), 200);
        }

        if ($method === 'POST' || $method === 'PUT') {
            $postData = $this->request->post();

            if (empty($postData)) {
                return $this->createResponse($this->createResponseData(false, [], "No data for save or update"), 500);
            }

            $oSettings = new Settings();
            $oSettings->loadSafe($postData);
            $oSettings->setUser_Id(htmlspecialchars($this->user_id));
            $ok = $oSettings->save();

            if ($ok === true) {
                return $this->createResponse($this->createResponseData(true, [], "OK"), 201);
            } else {
                return $this->createResponse($this->createResponseData(false, [], "Error"), 500);
            }

        }
    }

    public function actionSignup()
    {
        $post = $this->request->post();

        if (!empty($post)) {
            $user = new User();
            
            $user->loadSafe($post);
 
            $ok = $user->validate();
            
            
            $returnData =[
                'login' =>$user->getLogin(),
                'name' =>$user->getName(),
            ];

            if ($ok !== true) {
                return $this->createResponse($this->createResponseData(false, $returnData, 'Inputed data are invalid!'), 400);
            }
            
            $user->hashPassword();
            
            //check login unique.
            
            if (!$user->CheckUnique()) {
                return $this->createResponse($this->createResponseData(false, $returnData, 'Login already taken'), 400);
            }
            
            
            //save new user
           
            $success = $user->save();

            if (!$success) {
                return $this->createResponse($this->createResponseData(false, $returnData, "Server error"), 500);
            }

           
            //if data are saved, create response with code 200

            return $this->createResponse($this->createResponseData(true, null, "User has been registered successfully!"), 201);
        } else {
            // output registrqation form
            return $this->createResponse($this->createResponseData(false, null, "Login data hasn't ben recieved"), 200);
        }
    }
    
    public function changePassword()
    {
        $post = $this->request->post();
        
        if (empty($post)) {
            return $this->createResponse($this->createResponseData(false, null, "No data"), 500);
        }

        //For change password user should be authorised.

        if (is_null(Reg::$app->user_id)) {
            return $this->createResponse($this->createResponseData(false, null, "Not authorized!"), 401);
        }

        $user = User::findById(Reg::$app->user_id, false);

        if (!$user instanceof User) {
            return $this->createResponse($this->createResponseData(false, null, "Error get user!"), 500);
        }
        
        $currentPasword = $post['currentPasword'] ?? '';

        if ($user->verifyPassword($currentPasword) !== true) {
            return $this->createResponse($this->createResponseData(false, null, "Current password is invalid!"), 500);
        }

        $newPassword = $post['newPassword'] ?? '';
        $user->setPassword($newPassword);
        $ok = $user->validate();

        if (!$ok === true) {
            return $this->createResponse($this->createResponseData(false, null, "error validate data!"), 500);
        }
        
        $user->hashPassword();

        $updated = $user->update();

        if ($updated === true) {
            return $this->createResponse($this->createResponseData(true, null, "Password has been updated"), 200);
        } else {
            return $this->createResponse($this->createResponseData(false, null, "Password hasn't been updated"), 500);
        }
    }

    public function actionDelete()
    {
        $post = $this->request->post();
        
        if (!empty($post) && isset($post['login'])) {
            $login = \filter_var($post['login'], FILTER_SANITIZE_EMAIL);
            
            $user = User::find()->where(['login = :login'])->setParams(['login' => $login])->limit(1)->one();
            
            if (is_object($user) && $user instanceof User) {
                $delited = $user->delete();
                
                if ($delited === true) {
                    return $this->createResponse($this->createResponseData(true, null, "User has been deleted successfully!"), 200);
                }
                
                return $this->createResponse($this->createResponseData(false, null, "User hasn't been deleted!"), 400);
            }
        }
         
        return $this->createResponse($this->createResponseData(false, null, "login hasn't been transfered! Delete field!"), 400);
    }
}
