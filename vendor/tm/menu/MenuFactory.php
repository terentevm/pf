<?php

namespace tm\menu;

abstract class MenuFactory
{
    public static function getMenuBuilder(string $lang)
    {
        switch ($lang) {
            case 'en':
                return new \tm\menu\EngMenu();
                break;
            // case 'cs':
            //     return new \tm\menu\CzMenu();
            //     break;
            case 'ru':
                return new \tm\menu\RusMenu();
                break;
            default:
                return new \tm\menu\EngMenu();
                break;
        }
    }
}