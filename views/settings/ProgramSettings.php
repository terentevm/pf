<?php
    

    $render_param['form_header'] = 'Program settings';
    $currency = models\Currency::findByUser($_SESSION['user_id'],50,0,true);
    $wallets = models\Wallets::findByUser($_SESSION['user_id'],50,0,true);
    
    $render_param['currency_list'] = $currency;
    $render_param['wallets'] = $wallets;

    if (is_null($vars['currency'])) {
        $render_param['currency_id'] = $currency[0]['id'];
    } else {
        $render_param['currency_id'] = $vars['currency']['id'];
    }

    if (is_null($vars['wallet'])) {
        $render_param['wallet_id'] = $wallets[0]['id'];
    } else {
        $render_param['wallet_id'] = $vars['wallet']['id'];
    }

    
    
    $template = $twig->load('ProgramSettings.twig');
    $html = $template->render($render_param);    

    return $html;

