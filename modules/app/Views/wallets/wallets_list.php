<?php
$render_param['vars'] = $vars;
$template = $twig->load('tmpl_wallets_list.twig');
$html = $template->render($render_param);

return $html;
