<?php

namespace Base;

use Twig_Environment;
use Twig_Loader_Filesystem;
class View{
    public $route = [];
    public $layout;
    public $view;

    public function __Construct($route, $layout = '', $view = ''){
        $this->route = $route;
        
        if ($layout === false){
            $this->layout = false;
        }
        else{
            $this->layout = $layout ?: LAYOUT;
        }
        
        $this->view = $view;
    }
    
    public function debug($arr){
        echo '<pre>' .print_r($arr,true).'</pre>';
    }
    public function Render($vars){
        
		
        $file_view = APP . "/Views/{$this->route['controller']}/{$this->view}.php";
        $file_config = APP . "/config/config_view.php";
        $render_param = [];
        if(is_file($file_config)){
            require $file_config;
            $head_js = $this->getIncludeJS($scripts, $this->view, 'head');
            $body_begin_js = $this->getIncludeJS($scripts, $this->view, 'body_begin');
            $body_end_js = $this->getIncludeJS($scripts, $this->view, 'body_end');
            $footer_js = $this->getIncludeJS($scripts, $this->view, 'body_end');
            
            if(isset($_SESSION['csrf_token'])){
                $render_param['csrf_token'] = $_SESSION['csrf_token'];   
            }
    
            if (isset($head_js)){
                $render_param['head_js'] = $head_js;    
            }
            if (isset($body_begin_js)){
                $render_param['body_begin_js'] = $body_begin_js;    
            }
            if (isset($body_end_js)){
                $render_param['body_end_js'] = $body_end_js;    
            }
            if (isset($footer_js)){
                $render_param['footer_js'] = $footer_js;    
            }
        }
        

        if(is_file($file_view)){
            //register view diectory as directory for look up templates twig.
			$loader = new Twig_Loader_Filesystem( array(APP. '/Views/layouts', APP. '/Views/templates', dirname($file_view));
			$twig = new Twig_Environment($loader, array('cache' => APP. '/Views/compilation_cache','auto_reload' => true));
			require $file_view;
        }
        else{
            echo "<p>Не найден вид {$file_view}</p>";
        }

        
    }
    
    public function getIncludeJS($scripts,$view,$part){
       
        $result = [];
        
        if(key_exists('*', $scripts)){
            $common_scripts = $scripts['*'];    
        
            foreach ($common_scripts as $script){
                if($script['part'] == $part){
                $result[] = $script['link'];    
                }
            }    
        }
        
        if(key_exists($view, $scripts)){
            $view_scripts = $scripts[$view];
        
            foreach ($view_scripts as $script){
                if($script['part'] == $part){
                    $result[] = $script['link'];    
                }
            }
        }
        
        return $result;
    }
}