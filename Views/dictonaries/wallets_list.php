<?php
$template = $twig->load('wallets_list.twig');
echo $template->render(array('head_title' => 'Wallets'));
$this->Debug($vars);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

