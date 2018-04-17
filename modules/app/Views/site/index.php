<?php
$template = $twig->load('index.twig');
$result = $template->render($render_param);

return $result;
