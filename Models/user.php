<?php

namespace Models;
use Base\Model;
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
    
    use Base\TraitModelFunc;
    
    public function getProperties(){
        
        return get_object_vars($this);
        
    }
    public function getDbColumnes(){
        
        return ['id', 'code', 'name', 'short_name', 'user_id'];
        
    }
    public static function setTableName(){
        return 'users';
    }
    
    public function CheckUnique() {
        $sql = "SELECT * FROM {$this->table} WHERE login = :login";
        $param = [
            ':login' =>$this->login
            ];
        
            $QueryResult = $this->pdo->Query($sql, $param);
            
            if(empty($QueryResult)){
                return TRUE;
            }
            
            return FALSE;
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
        
        $success = $this->pdo->Execute($sql, $param);
        
        return $success;
    }
    
    public function CheckAuthData(){
        $login = $this->login;
        $inPass = $this->password;
        
        $sql = "SELECT users.id, users.password FROM users WHERE users.login = :login";
        $param = [':login' => $login];
        
        $QueryResult = $this->pdo->Query($sql, $param);
        
        if (empty($QueryResult)){
            return ['success' => FALSE,'user_id' => ''];
        }
        
        $data_auth = $QueryResult[0];
        
        if (password_verify($inPass, $data_auth['password'])){
            $this->id = $data_auth['id'];
            
            return ['success' => TRUE,'user_id' => $data_auth['id']];
        }
        
        return ['success' => FALSE,'user_id' => ''];
    }
    
    public function StartSession($options){
        
        $hash = crypt($this->password,$options['user_agent']);
        $sql = "INSERT INTO sessions (id,user_id,useragent,time,hash) VALUES (:id,:user_id,:useragent,:time,:hash)";
        
        $param = [
            ':id' => $this->GetGuide(),
            ':user_id' => $this->id,
            ':useragent' =>$options['user_agent'],
            ':time' => date("Y-m-d H:i:s"),
            ':hash' => $hash
        ];
        
        $success = $this->pdo->Execute($sql, $param);
        
        if($success){
            $_SESSION['user_id'] = $this->id;
            setcookie('hash',$hash, time()+(60*60*24*30), '/');
        }
    }
    
    public function Logout(){
        if($this->id === null){
            return;
        }
        
        $sql = "DELETE FROM sessions WHERE sessions.user_id = :user_id";
        $param =[':user_id' => $this->id];
        
        $success = $this->pdo->Execute($sql, $param);
        
        return;
    }
    
    public function GetAll_User_id(){
        $sql = "SELECT id FROM users WHERE login <> 'mick911@mail.ru'";
        $result = $this->pdo->Query($sql);
        
        return $result;
    }
    
}
