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
<html lang=\"cs style=\"height: 100%\">
  <head>
    <!-- Required meta tags -->
    ";
        // line 6
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["metatags"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["meta"]) {
            // line 7
            echo "    ";
            echo $context["meta"];
            echo "
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['meta'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 9
        echo "    ";
        // line 10
        echo "    <!--<meta http-equiv=\"Cache-Control\" content=\"no-cache\"><meta http-equiv=\"Cache-Control\" content=\"no-cache\">-->
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
        // line 22
        $this->displayBlock('script_head', $context, $blocks);
        // line 26
        echo "  

  </head>
  <body style=\"height: 100%; background: #F5F3E5;\">
    ";
        // line 30
        $this->displayBlock('script_body_begin', $context, $blocks);
        // line 35
        echo "      <div class=\"navmenu navmenu-default navmenu-fixed-left offcanvas-sm\">
      <a class=\"navmenu-brand visible-md visible-lg\" style=\"font-style:oblique; color: #f7f7f7;\" href=\"/site/index\">Project name</a>

      <ul class=\"nav navmenu-nav\">
        <li><a href=\"/site/index\" class=\"navtext\" style= \"color: #f7f7f7;\"> <img class=\"photo\" src=\"/public/src/home.png\"/> Home</a></li>
        <li><a href=\"#\" class=\"navtext\" style= \"color: #f7f7f7;\"><img class=\"photo\" src=\"/public/src/transactions.png\"/> Transactions</a></li>
        <li><a href=\"/site/settings\" class=\"navtext\" style= \"color: #f7f7f7;\"><img class=\"photo\" src=\"/public/src/settings.png\"/> Settings</a></li>
        <li><a href=\"/user/logout\" class=\"navtext\" style= \"color: #f7f7f7;\"><img class=\"photo\" src=\"/public/src/logout.png\"/> Logout</a></li>
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
        // line 56
        $this->displayBlock('content', $context, $blocks);
        // line 57
        echo "      </div><!-- /.container -->
    ";
        // line 58
        $this->displayBlock('script_body_end', $context, $blocks);
        // line 62
        echo "\t
    
    <img id=\"loadImg\" src=\"/public/src/ajax-loader.gif\"/>
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

    // line 30
    public function block_script_body_begin($context, array $blocks = array())
    {
        // line 31
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["body_begin_js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 32
            echo "      <script src=\"";
            echo twig_escape_filter($this->env, $context["link"], "html", null, true);
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "    ";
    }

    // line 56
    public function block_content($context, array $blocks = array())
    {
    }

    // line 58
    public function block_script_body_end($context, array $blocks = array())
    {
        // line 59
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["body_end_js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 60
            echo "      <script src=\"";
            echo twig_escape_filter($this->env, $context["link"], "html", null, true);
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 62
        echo "    ";
    }

    public function getTemplateName()
    {
        return "main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  173 => 62,  164 => 60,  159 => 59,  156 => 58,  151 => 56,  147 => 34,  138 => 32,  133 => 31,  130 => 30,  126 => 26,  117 => 24,  112 => 23,  109 => 22,  99 => 62,  97 => 58,  94 => 57,  92 => 56,  69 => 35,  67 => 30,  61 => 26,  59 => 22,  45 => 10,  43 => 9,  34 => 7,  29 => 6,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "main.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\layouts\\main.twig");
    }
}
