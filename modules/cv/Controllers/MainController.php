<?php

namespace cv\controllers;

use tm\Controller;
use tm\menu\MenuFactory;

class MainController extends Controller
{
    public static $defaultAction = 'index';
    
    public function ActionIndex()
    {
        
        $lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

        $menuBuilder = MenuFactory::getMenuBuilder($lang);

        $menu = $menuBuilder->getMenuStructure();
        
        return $this->createResponse($menu);
    }
}