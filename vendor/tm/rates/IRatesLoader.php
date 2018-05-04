<?php

namespace tm\rates;

interface IRatesLoader
{
    public function load(string $currencyCode, string $date1, string $date2) : array;
}