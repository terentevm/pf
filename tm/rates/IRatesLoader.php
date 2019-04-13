<?php

namespace tm\rates;

interface IRatesLoader
{
    /**
     * Loads currency rates from bank's api.
     * @param string $currencyCode Char currency code RUB, EUR, USD etc.
     * @param string $date1 'Y-m-d'
     * @param string $date2 'Y-m-d'
     * @return RateData
     * @throws RatesLoaderException
     */
    public function load(string $currencyCode, string $date1, string $date2) : RateData;
}
