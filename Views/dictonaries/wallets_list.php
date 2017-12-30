<?php
$template = $twig->load('wallets_list.twig');
$result = $template->render(array('head_title' => 'Wallets'));