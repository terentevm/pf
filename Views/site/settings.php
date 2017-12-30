<?php
$template = $twig->load('settings.twig');
$result = $template->render($render_param);

return $result;
