<?php
$template = $twig->load('index.twig');
$result = $template->render($render_param);

echo $result;

exit();
