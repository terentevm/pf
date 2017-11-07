<?php
$template = $twig->load('settings.twig');
$result = $template->render();

echo $result;

exit();
