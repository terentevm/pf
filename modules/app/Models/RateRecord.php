<?php
namespace app\Models;

use tm\Model;

class RateRecord extends Model
{
    private $id = null;
    private $userId = null;
    private $date = "";
    private $dateInt = "";
    private $currencyId = null;
    private $mult = 1;
    private $rate = 0;

    //getters

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getDateInt()
    {
        return $this->dateInt;
    }

    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    public function getMult()
    {
        return $this->mult;
    }

    public function getRate()
    {
        return $this->rate;
    }

    //setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setDate(string $date)
    {
        $this->date = $date;
    }

    public function setDateInt(int $dateInt)
    {
        $this->dateInt = $dateInt;
    }

    public function setCurrencyId(string $currencyId)
    {
        $this->currencyId = $currencyId;
    }

    public function setMult(int $mult)
    {
        $this->mult = $mult;
    }

    public function setRate(float $rate)
    {
        $this->rate = $rate;
    }

}