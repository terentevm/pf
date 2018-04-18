<?php

namespace tm\menu;

class EngMenu
{
    public function __construct()
    {

    }

    public function getMenuStructure() : array
    {
        $menu = [
            'flag' =>"src/img/flags.svg#icon-flag-en",
            'sideMenu' => [
                'PERSONAL DATA',
                'PROFILE',
                'EDUCATION',
                'EMPLOYMENT HISTORY',
                'SCILLS'
            ]

        ];

        return $menu;
    }
}