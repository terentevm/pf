<?php

$template = $twig->load('index.twig');   


$render_param['flag'] = $vars->data['flag'];
$render_param['sideMenu'] = $vars->data['sideMenu'];
$result = $template->render($render_param);

return $result;