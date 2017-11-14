<?php
$template = $twig->load('settings.twig');
$result = $template->render($render_param);

echo $result;

exit();
