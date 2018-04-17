<?php
$template = $twig->load('currency_list.twig');
$result = $template->render($render_param);

return $result;