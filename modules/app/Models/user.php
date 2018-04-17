<?php

namespace app\Models;
use tm\Model;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Exceptions\NestedValidationException;
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
    
    public function __construct($id = null, $login = '', $password = '', $name = '') {
 
        $this->login = $login;
        $this->password = $password; 
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
    
    public function checkUnique() {
        $db_rec = static::find()->where(['login = :login'])->asArray()->setParams(['login' => $this->login])->limit(1)->one();
        
        //if record with this login exist in database return false
        return empty($db_rec) ? true : false;
    }
    
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
    
    public static function verify($login, $password) {
       $db_rec = static::find()->asArray()->where(['login = :login'])->setParams(['login' => $login])->limit(1)->one();
       
       if (empty($db_rec)) {
           return false;
       }
       
       if (password_verify($password, $db_rec['password'])) {
           return $db_rec['id'];
       }
       
       return false;
    }
    
    public function validate() {
        $validator = v::attribute('login', v::notEmpty()->Email())
                    ->attribute('password', v::notEmpty()->stringType())
                    ->attribute('name', v::notEmpty()->stringType());
        
        try {
            $validator->assert($this);
            return true;
        } catch (NestedValidationException $e) {
            $errors = $e->getMessages();
            return false;
        }
    }
    
    public function getValidationRules() {
        return [
            'login' =>['Email']
        ];
    }
}
