<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controllers;

use tm\Controller;
use tm\Response;

class AppController extends Controller
{
    public static $defaultAction = 'index';
    
    public function ActionIndex()
    {
        $index_file = MODULES_PATH . "/app/Views/index.html";
        $html = file_get_contents($index_file);
        $response = new Response(200, $html);
        return $response;
    }
}
