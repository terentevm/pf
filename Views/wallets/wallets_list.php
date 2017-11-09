<?php
$render_param['vars'] = $vars;
$template = $twig->load('tmpl_wallets_list.twig');
$result = $template->render($render_param);

echo $result;

exit();

