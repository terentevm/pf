<?php
$template = $twig->load('index.twig');

$render_param['flag'] = $vars['flag'];
$render_param['sideMenu'] = $vars['sideMenu'];
$result = $template->render($render_param);

return $result;