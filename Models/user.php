<?php

namespace Models;
use Base\Model;
use Base\TraitModelFunc;
/**
 * Description of user
 *
 * @author terentyev.m
 */
class User extends Model{
    
    private $id = null;
    private $login;
    private $password;
    private $name;
    
    use TraitModelFunc;
    
    public function getProperties(){
        
        return get_object_vars($this);
        
    }
    
    public static function setTableName(){
        return 'users';
    }
    
    public function CheckUnique() {
        
        $user = $this->getUser($this->login);
        
        if(empty($user)){
            return TRUE;
        }
            
        return FALSE;
    }
    
    private function getUser(string $login) {
        $db = $this->getDb();
        $sql = "SELECT id, password, name FROM users WHERE login = :login LIMIT 1";
        
        $param = [
            ':login' =>$login
            ];
        
        $success = $db->prepare($sql);
        
        if (!$success) {
            die("System database error");
        }
        $db->execute($param);
        $user = $db->fetchOne();
        
        return $user;
    }
    
    public function CreateNewUser(){
        $new_id = $this->GetGuide();
        $login = $this->login;  
        $pass = password_hash($this->attributes['password'], PASSWORD_DEFAULT);
        $name = $this->name;
        
        $sql = "INSERT INTO users (id,login,password,name) VALUES (:id,:login,:password,:name)";
        $param = [
            ':id' => $new_id,
            ':login' => $login,
            ':password' => $pass,
            ':name' => $name
        ];
        
        $db = $this->getDb();
        $db->prepare($sql);
        $success = $db->execute($param);
        
        return $success;
    }
    
    public function CheckAuthData(){
        $login = $this->login;
        $inPass = $this->password;
        
        $user = $this->getUser($login);
        
        if (empty($user)){
            return ['success' => FALSE,'user_id' => ''];
        }
        
        if (password_verify($inPass, $user['password'])){
            $this->id = $user['id'];
            
            return ['success' => TRUE,'user_id' => $user['id']];
        }
        
        return ['success' => FALSE,'user_id' => ''];
    }
    
    public function StartSession(){

        $_SESSION['user_id'] = $this->id;
    }
    
    public function Logout(){
        if($this->id === null){
            return;
        }
        
        
        unset($_SESSION['user_id']);
        unset($_SESSION['success']);
        
        return;
    }
    
    public function GetAll_User_id(){
        $sql = "SELECT id FROM users WHERE login <> 'mick911@mail.ru'";
        $result = $this->pdo->Query($sql);
        
        return $result;
    }
    
}
