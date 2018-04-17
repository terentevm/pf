<?php
	
	if(is_array($vars) && !empty($vars)){
		
		foreach ($vars as $key => $value){
			$render_param[$key] = $value;	
		}
	}
	
	$template = $twig->load('form_currency_element.html.twig');
	$result = $template->render($render_param);

	return $result;

