<?php
    
    if(isset($_SESSION['error'])){
        $render_param['error'] = $_SESSION['error'];   
    }
    $render_param['isNotAjax'] = !$_SESSION['isAjax'];
    
    if(is_array($vars) && !empty($vars)){
		
		foreach ($vars as $key => $value){
			$render_param[$key] = $value;	
		}
	}

    $template = $twig->load('tmpl_signup.twig');
    $html = $template->render($render_param);
    
    unset($_SESSION['error']);    
    
    return $html;
