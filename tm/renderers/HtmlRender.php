<?php

namespace tm\renderers;

use tm\View;
use tm\ResponseData;
use tm\renderers\RenderInterface;
use tm\Registry;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_Error_Loader;

class HtmlRender extends View implements RenderInterface
{
    public $route = [];
    public $pathView = "";
    public $layout;
    public $view;

    public function __Construct($route, $layout = '', $view = '', $module = 'cv')
    {
        $this->route = $route;
        
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
        
        $this->view = $view;
        
        $this->pathView = MODULES_PATH . "/" . CURRENT_MUDULE;
    }

    public function render(ResponseData $vars) : string
    {
        $file_view = $this->pathView . "/Views/{$this->route['controller']}/{$this->view}.php";
        $file_config = APP . "/config/config_view.php";
        $render_param = [];
        $this->setMeta($render_param);
        $render_param['isNotAjax'] = !Registry::$app->request->isAjax();
        
        if (is_file($file_config)) {
            require $file_config;
            $head_js = $this->getIncludeJS($scripts, $this->view, 'head');
            $body_begin_js = $this->getIncludeJS($scripts, $this->view, 'body_begin');
            $body_end_js = $this->getIncludeJS($scripts, $this->view, 'body_end');
            $footer_js = $this->getIncludeJS($scripts, $this->view, 'body_end');
            
            if (isset($_SESSION['csrf_token'])) {
                $render_param['csrf_token'] = $_SESSION['csrf_token'];
            }
    
            if (isset($head_js)) {
                $render_param['head_js'] = $head_js;
            }
            if (isset($body_begin_js)) {
                $render_param['body_begin_js'] = $body_begin_js;
            }
            if (isset($body_end_js)) {
                $render_param['body_end_js'] = $body_end_js;
            }
            if (isset($footer_js)) {
                $render_param['footer_js'] = $footer_js;
            }
        }
        
        ob_start('ob_gzhandler');
        $render_param['layout'] = $this->layout . '.twig';
        header("Content-Encoding: gzip");
        if (is_file($file_view)) {
            //register view diectory as directory for look up templates twig.
            $loader = new Twig_Loader_Filesystem(array($this->pathView .'/Views/layouts', dirname($file_view)));
            $twig = new Twig_Environment($loader, array('cache' => $this->pathView . '/Views/compilation_cache','auto_reload' => false));
            $html = require $file_view;
        } else {
            $html;
        }
        
        ob_clean();
        return $html;
    }

    public function setMeta(&$render_param)
    {
        $render_param['metatags'] =[
            "<meta charset='utf-8'>",
            "<meta http-equiv='X-UA-Compatible' content='IE=edge' />",
            "<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>",
            //"<meta name='ccsrf_token' content='" . $_SESSION['csrf_token'] . "'>",
            "<META HTTP-EQUIV='Content-language' CONTENT='" . LANGUAGE . "'>"
        ];
    }

    public function getIncludeJS($scripts, $view, $part)
    {
        $result = [];
        
        if (key_exists('*', $scripts)) {
            $common_scripts = $scripts['*'];
        
            foreach ($common_scripts as $script) {
                if ($script['part'] == $part) {
                    $result[] = $script['link'];
                }
            }
        }
        
        if (key_exists($view, $scripts)) {
            $view_scripts = $scripts[$view];
        
            foreach ($view_scripts as $script) {
                if ($script['part'] == $part) {
                    $result[] = $script['link'];
                }
            }
        }
        
        return $result;
    }
}
