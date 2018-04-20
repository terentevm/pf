<?php

/* material.twig */
class __TwigTemplate_72caa4e67e87a38371f1de305d5ed201f87400e2cb43121dfdb783582d7bc4e9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
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
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <title>Mikhail Terentev CV</title>
    <link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">
    <link type=\"text/css\" rel=\"stylesheet\" href=\"/pf/public/css/materialize.min.css\" />
    <link type=\"text/css\" rel=\"stylesheet\" href=\"/pf/public/css/font-awesome.min.css\" />

  </head>
  <body>
    

    <div class=\"container\">
    
    ";
        // line 19
        $this->displayBlock('content', $context, $blocks);
        // line 20
        echo "    
    </div>
    
    ";
        // line 23
        $this->displayBlock('script_body_end', $context, $blocks);
        // line 27
        echo "\t

  </body>
  
</html>
";
    }

    // line 19
    public function block_content($context, array $blocks = array())
    {
    }

    // line 23
    public function block_script_body_end($context, array $blocks = array())
    {
        // line 24
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["body_end_js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 25
            echo "      <script src=\"";
            echo twig_escape_filter($this->env, $context["link"], "html", null, true);
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "    ";
    }

    public function getTemplateName()
    {
        return "material.twig";
    }

    public function getDebugInfo()
    {
        return array (  81 => 27,  72 => 25,  67 => 24,  64 => 23,  59 => 19,  50 => 27,  48 => 23,  43 => 20,  41 => 19,  21 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "material.twig", "C:\\Apache\\Apache24\\htdocs\\pf\\modules\\app\\Views\\layouts\\material.twig");
    }
}
