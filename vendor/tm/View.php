<?php

namespace tm;

use tm\Base;
use tm\Request;
use tm\renderers\JsonRender;
use tm\renderers\HtmlRender;

class View extends Base
{
    
    public static function getRenderer($response_type,$route, $layout = '', $view = '') {
        
        switch ($response_type) {
            case 'json' : 
                $renderer =new JsonRender();
                break;
            default :
                $renderer = new HtmlRender($route, $layout, $view);
        }

        return $renderer;
    }
    
}