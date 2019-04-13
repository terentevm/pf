<?php
/**
 * Created by PhpStorm.
 * User: zaich
 * Date: 13.04.2019
 * Time: 20:43
 */

namespace tm\rates;


class RateData
{
    private $code;
    private $mult = 1;
    private $rates = [];

    public function __construct(string $code, int $mult = 1)
    {
        $this->code = $code;
        $this->mult = $mult;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return int
     */
    public function getMult(): int
    {
        return $this->mult;
    }

    /**
     * @return array
     */
    public function getRates(): array
    {
        return $this->rates;
    }

    public function addRate(string $date, float $rate)
    {
        $dateInt = strtotime($date);
        $this->rates[$dateInt] = ['date' => $date, 'rate'=>$rate];
    }

}