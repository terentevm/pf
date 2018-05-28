<?php

/* material.twig */
class __TwigTemplate_043e10823448eeeaec87c364b8e9409a82b03fc12fdcfcba675c41a5dc5ffb27 extends Twig_Template
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
<!--http://materializecss.com/color.html-->
<html lang=\"cs style=\"height: 100%\">
  <head>
    <!-- Required meta tags -->
    ";
        // line 7
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["metatags"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["meta"]) {
            // line 8
            echo "    ";
            echo $context["meta"];
            echo "
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['meta'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "    ";
        // line 11
        echo "    <!--<meta http-equiv=\"Cache-Control\" content=\"no-cache\"><meta http-equiv=\"Cache-Control\" content=\"no-cache\">-->
    <!-- Bootstrap CSS -->
    <style>
    /*описание стилей*/
    #loadImg{position:absolute; z-index:1000; display:none}
    </style>
    <link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">
   <link rel=\"stylesheet\" href=\"/public/materialize/css/materialize.min.css\">
    <link href=\"/public/css/pf.css\" rel=\"stylesheet\">

    
    ";
        // line 22
        $this->displayBlock('script_head', $context, $blocks);
        // line 26
        echo "  
    <div class=\"container\">
        <nav class=\"light-green darken-2 hide-on-large-only\">
        <div class=\"nav-wrapper\">
        <a id=\"mobile_menu_button\" href=\"#\" data-activates=\"slide-out\" class=\"button-collapse  waves-effect waves-light light-green darken-2 top-nav full hide-on-large-only\"><i class=\"material-icons\">menu</i></a>
        <div class=\"brand-logo right\" style=\"height: inherit; width: 64px;\">
        <object id=\"front-page-logo\" type=\"image/svg+xml\" data=\"/public/src/logo_var2.svg\" style=\"height: inherit; width: 64px;\">Your browser does not support SVG</object>
        </div>
        </div>
        </nav>

    </div>
  </head>
  <body style=\"height: 100%;\">
    ";
        // line 40
        $this->displayBlock('script_body_begin', $context, $blocks);
        // line 45
        echo "

    <ul id=\"slide-out\" class=\"side-nav fixed light-green darken-2 hoverable\">
    
    <div class=\"card no-padding light-green darken-2\">
     <div class=\"card-image light-green darken-2\">
          <div>
            <object id=\"front-page-logo\" type=\"image/svg+xml\" data=\"/public/src/title_panel.svg\" style=\"height: 400; width: 200px;\">Your browser does not support SVG</object>
          </div>
        </div>
    </div>
    <ul>
    <li><a href=\"/site/index\">Home<i class=\"material-icons\">home</i></a></li>        
    <li><a href=\"#\">Transactions<i class=\"material-icons\">event_note</i></a></li> 
    <li><a href=\"/site/settings\">Settings<i class=\"material-icons\">settings</i></a></li> 
    <li><a href=\"/user/logout\">Exit<i class=\"material-icons\">exit_to_app</i></a></li> 
    </ul>
    </ul>

    <div class=\"container\">
    
    ";
        // line 66
        $this->displayBlock('content', $context, $blocks);
        // line 67
        echo "    
    </div><!-- /.container -->
    
    ";
        // line 70
        $this->displayBlock('script_body_end', $context, $blocks);
        // line 74
        echo "\t
    
    <img id=\"loadImg\" src=\"/public/src/ajax-loader.gif\"/>
    <script>
       \$('.button-collapse').sideNav();
    </script>
  </body>
  
</html>
";
    }

    // line 22
    public function block_script_head($context, array $blocks = array())
    {
        // line 23
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["head_js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 24
            echo "            <script src=\"";
            echo twig_escape_filter($this->env, $context["link"], "html", null, true);
            echo "\"></script>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "    ";
    }

    // line 40
    public function block_script_body_begin($context, array $blocks = array())
    {
        // line 41
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["body_begin_js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 42
            echo "      <script src=\"";
            echo twig_escape_filter($this->env, $context["link"], "html", null, true);
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "    ";
    }

    // line 66
    public function block_content($context, array $blocks = array())
    {
    }

    // line 70
    public function block_script_body_end($context, array $blocks = array())
    {
        // line 71
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["body_end_js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 72
            echo "      <script src=\"";
            echo twig_escape_filter($this->env, $context["link"], "html", null, true);
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 74
        echo "    ";
    }

    public function getTemplateName()
    {
        return "material.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array(  188 => 74,  179 => 72,  174 => 71,  171 => 70,  166 => 66,  162 => 44,  153 => 42,  148 => 41,  145 => 40,  141 => 26,  132 => 24,  127 => 23,  124 => 22,  111 => 74,  109 => 70,  104 => 67,  102 => 66,  79 => 45,  77 => 40,  61 => 26,  59 => 22,  46 => 11,  44 => 10,  35 => 8,  30 => 7,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "material.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\layouts\\material.twig");
    }
}
