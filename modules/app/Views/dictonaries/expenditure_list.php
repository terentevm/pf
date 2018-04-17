<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$this->Debug($vars);
echo '<ul>';
foreach ($vars as $arr_elem){
    echo '<li>';
    echo $arr_elem['elements']['name'];
    echo '</li>';
    $childs = $arr_elem['childs'];
    if(!empty($childs)){
        echo '<ul>';
        foreach ($childs as $child){
            echo '<li>';
            echo $child['elements']['name'];
            echo '</li>';
            echo '</br>';
        }
        echo '</ul>';
        echo '</br>';
    }
}
echo '</ul>';
