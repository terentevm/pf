<?php

if (isset($_SESSION['error'])) {
    $render_param['error'] = $_SESSION['error'];
}

$render_param['isNotAjax'] = !$_SESSION['isAjax'];

if (is_array($vars) && !empty($vars)) {

    

    $wallet = $vars['element'];
    
    if (!$wallet['id'] == ''){
       $render_param['form_header'] = 'Wallet: ' . $wallet['name'];
    }
    else {
       $render_param['form_header'] = 'Wallet: new item';
    }
    
    foreach ($wallet as $key => $value) {
        if ($key == 'is_creditcard') {
            if ($value == '1') {
                $render_param['is_checked'] = "checked = 'checked'";
                continue;
            }
        }

        $render_param[$key] = $value;
    }
}

$render_param['currency_list'] = $vars['currency_list'];

$template = $twig->load('tmpl_wallets_element.twig');
$html = $template->render($render_param);

unset($_SESSION['error']);

echo $html;

if ($_SESSION['isAjax']) {
    exit();
}

