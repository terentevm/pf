<?php

namespace tm\rates;

use tm\rates\CNBLoader;

class LoaderFabric
{
    public static function getLoader()
    {
        return new CNBLoader();
    }
}
