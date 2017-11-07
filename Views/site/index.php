<?php
$template = $twig->load('index.twig');
$result = $template->render();

echo $result;

exit();
