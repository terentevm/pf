<?php
    
    if(is_array($vars) && !empty($vars)){
		
		foreach ($vars as $key => $value){
			$render_param[$key] = $value;	
		}
    }
    
    if(isset($_SESSION['error'])){
        $render_param['error'] = $_SESSION['error'];   
    }
    
    $template = $twig->load('login.twig');
    $html = $template->render($render_param);
    
    if(isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
        

    return $html;
    

