<?php

namespace app\Models;

use tm\Model;

use app\Models\Settings;
use app\Models\Currency;
use app\Models\Rates;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Description of user
 *
 * @author terentyev.m
 */
class User extends Model
{
    private $id = null;
    private $login;
    private $password;
    private $name;
    
    public function __construct($id = null, $login = '', $password = '', $name = '')
    {
        $this->login = $login;
        $this->password = $password;
        $this->name = $name;
    }
    
    
    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function checkUnique()
    {
        $db_rec = static::find()->where(['login = :login'])->asArray()->setParams(['login' => $this->login])->limit(1)->one();
        
        //if record with this login exist in database return false
        return empty($db_rec) ? true : false;
    }
    
    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
    
    public static function verify($login, $password)
    {
        $db_rec = static::find()->asArray()->where(['login = :login'])->setParams(['login' => $login])->limit(1)->one();
       
        if (empty($db_rec)) {
            return false;
        }
       
        if (password_verify($password, $db_rec['password'])) {
            return $db_rec['id'];
        }
       
        return false;
    }
    
    public function verifyPassword($password)
    {
        return password_verify($this->password, $password);
    }

    public static function getFilterRules()
    {
        return [
            'login' => FILTER_SANITIZE_EMAIL,
            'password' => FILTER_DEFAULT,
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
    }
        
    public function validate()
    {
        $validator = v::attribute('login', v::notEmpty()->Email())
                    ->attribute('password', v::notEmpty()->stringType()->length(3, null))
                    ->attribute('name', v::notEmpty()->stringType());
        
        try {
            $validator->assert($this);
            return true;
        } catch (NestedValidationException $e) {
            $errors = $e->getMessages();
            return false;
        }
    }

    public function save($upload_mode = false)
    {
        //for creating new user necessary to do following actions:
        //1 - save user
        //2 - save default currency
        //3 - for default currency set default rate
        //4 - save record with user settings
        
        $container = Reg::getContainerDI();
        
        $sysCurrency_arr = $container['conf']->getSystemCurrency();

        try {
            $mapper = Mapper::getMapper(get_called_class());
        }
        catch(\Throwable $e) {
            return false;
        }
        
        
        $db = $mapper->getDb();
        
        $db->beginTransaction();
        
        $success = $mapper->save($this, false, false);
        
        if ($success) {
            $db->rollBackTransaction();
            return false;
        }

        //save system currency
        $currency = new Currency();
            
        $currency->setUser_id($this->id);
        $currency->setName($sysCurrency_arr['name']);
        $currency->setShort_Name($sysCurrency_arr['short_name']) ;
        $currency->setCode($sysCurrency_arr['code']);

        $success = $currency->save();

        if (!$success) {
            $db->rollBackTransaction();
            return false;
        }

        //save default rate for system currency

        $record = [
            'id' => null,
            'currency_id' =>  $currency->getId(),
            'date' => "1980-01-01",
            'dateInt' => strtotime("1980-01-01"),
            'mult' => 1,
            'rate' => 1
        ];
        
        $rates = new Rates();
        $rates->setDataset(array($record));
        
        $success = $rates->save();
        
        if (!$success) {
            $db->rollBackTransaction();
            return false;
        }

        //save settings

        $settings = new Settings($this->id, $currency->getId());
        $success = $settings->save();

        if (!$success) {
            $db->rollBackTransaction();
            return false;
        }

        $db->commitTransaction();

        return true;

    }

    

}
