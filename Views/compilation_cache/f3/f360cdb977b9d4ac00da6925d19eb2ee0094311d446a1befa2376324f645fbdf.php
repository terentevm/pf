<?php

/* main.twig */
class __TwigTemplate_1a58066c6ff2e878e3df75cc9bf68ef71fc4022eac7715a65189f0c2c1c5f517 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'script_head' => array($this, 'block_script_head'),
            'script_body_begin' => array($this, 'block_script_body_begin'),
            'content' => array($this, 'block_content'),
            'script_body_end' => array($this, 'block_script_body_end'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\" style=\"height: 100%\">
  <head>
    <!-- Required meta tags -->
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <meta name=\"ccsrf_token\" content= \"<?= \$_SESSION['csrf_token'] ?>\">
    <!--<meta http-equiv=\"Cache-Control\" content=\"no-cache\"><meta http-equiv=\"Cache-Control\" content=\"no-cache\">-->
    <!-- Bootstrap CSS -->
    <style>
    /*описание стилей*/
    #loadImg{position:absolute; z-index:1000; display:none}
    </style>
    <link rel=\"stylesheet\" href=\"/public/bootstrap/css/jasny-bootstrap.min.css\">
   <link rel=\"stylesheet\" href=\"/public/bootstrap/css/bootstrap.min.css\">
   <link rel=\"stylesheet\" href=\"/public/css/pf.css\">
   <link href=\"/public/bootstrap/navmenu.css\" rel=\"stylesheet\">
   <link href=\"/public/bootstrap-fileinput/css/fileinput.min.css\" rel=\"stylesheet\" />
    
    ";
        // line 20
        $this->displayBlock('script_head', $context, $blocks);
        // line 24
        echo "  

  </head>
  <body style=\"height: 100%\">
    ";
        // line 28
        $this->displayBlock('script_body_begin', $context, $blocks);
        // line 33
        echo "      <div class=\"navmenu navmenu-default navmenu-fixed-left offcanvas-sm\">
      <a class=\"navmenu-brand visible-md visible-lg\" style=\"font-style:oblique; color: #f7f7f7;\" href=\"/site/index\">Project name</a>

      <ul class=\"nav navmenu-nav\">
        <li><a href=\"/site/index\" class=\"navtext\" style= \"color: #f7f7f7;\">Home</a></li>
        <li><a href=\"#\" class=\"navtext\" style= \"color: #f7f7f7;\">Transactions</a></li>
        <li><a href=\"/site/settings\" class=\"navtext\" style= \"color: #f7f7f7;\">Settings</a></li>
        <li><a href=\"/user/logout\" class=\"navtext\" style= \"color: #f7f7f7;\">Logout</a></li>
      </ul>
    </div>

    <div class=\"navbar navbar-default navbar-fixed-top hidden-md hidden-lg\">
      <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"offcanvas\" data-target=\".navmenu\">
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
      </button>
      <a class=\"navbar-brand navtext\" href=\"/site/index\">Project name</a>
    </div>

    <div class=\"container\">
    ";
        // line 54
        $this->displayBlock('content', $context, $blocks);
        // line 55
        echo "      </div><!-- /.container -->
    ";
        // line 56
        $this->displayBlock('script_body_end', $context, $blocks);
        // line 60
        echo "\t
    
    <img id=\"loadImg\" src=\"/public/src/ajax-loader.gif\"/>
  </body>
  
</html>
";
    }

    // line 20
    public function block_script_head($context, array $blocks = array())
    {
        // line 21
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["head_js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 22
            echo "            <script src=\"";
            echo twig_escape_filter($this->env, $context["link"], "html", null, true);
            echo "\"></script>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo "    ";
    }

    // line 28
    public function block_script_body_begin($context, array $blocks = array())
    {
        // line 29
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["body_begin_js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 30
            echo "      <script src=\"";
            echo twig_escape_filter($this->env, $context["link"], "html", null, true);
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "    ";
    }

    // line 54
    public function block_content($context, array $blocks = array())
    {
    }

    // line 56
    public function block_script_body_end($context, array $blocks = array())
    {
        // line 57
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["body_end_js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 58
            echo "      <script src=\"";
            echo twig_escape_filter($this->env, $context["link"], "html", null, true);
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 60
        echo "    ";
    }

    public function getTemplateName()
    {
        return "main.twig";
    }

    public function getDebugInfo()
    {
        return array (  158 => 60,  149 => 58,  144 => 57,  141 => 56,  136 => 54,  132 => 32,  123 => 30,  118 => 29,  115 => 28,  111 => 24,  102 => 22,  97 => 21,  94 => 20,  84 => 60,  82 => 56,  79 => 55,  77 => 54,  54 => 33,  52 => 28,  46 => 24,  44 => 20,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "main.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\layouts\\main.twig");
    }
}
