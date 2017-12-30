<?php
	
	if(is_array($vars) && !empty($vars)){
		
		foreach ($vars[0] as $key => $value){
			$render_param[$key] = $value;	
		}
	}
	
	$template = $twig->load('form_currency_element.html.twig');
	$result = $template->render($render_param);

	return $result;

