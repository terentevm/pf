<?php

namespace tm\menu;

class RusMenu
{
    public function __construct()
    {

    }

    public function getMenuStructure() : array
    {
        $menu = [
            'flag' =>"src/img/flags.svg#icon-flag-ru",
            'sideMenu' => [
                'ПЕРСОНАЛЬНЫЕ ДАННЫЕ',
                'ПРОФАЙЛ',
                'ОБРАЗОВАНИЕ',
                'ИСТОРИЯ РАБОТЫ',
                'НАВЫКИ'
            ]

        ];

        return $menu;
    }
}