<?php
$render_param['vars'] = $vars;
$template = $twig->load('currency_list_data.twig');
$result = $template->render($render_param);

echo $result;

exit();

