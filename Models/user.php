<?php

namespace Models;
use tm\Model;
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
    
    public function __construct($login, $password, $name) {
 
        $this->login = $login;
        $this->password = $password; //password_hash($password, PASSWORD_DEFAULT);
        $this->name = $name;
    }
    
    
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    public static function checkUnique($login) {
        $db_rec = static::find()->where(['login: login'])->setParams(['login' => $login])->limit(1)->one();
        
        //if record with this login exist in database return false
        return empty($db_rec) ? true : false;
    }
    
    
    public static function verify($login, $password) {
       $db_rec = static::find()->where(['login: login'])->setParams(['login' => $login])->limit(1)->one();
       
       if (empty($db_rec)) {
           return false;
       }
       
       if (password_verify($password, $db_rec['password'])) {
           return true;
       }
       
       return false;
    }
}
