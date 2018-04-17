<?php

/* form_currency_element.html.twig */
class __TwigTemplate_1cba0d3e1bdddaeebd571ca2a573ba8145a029f8e480ec869380ebb264c4937d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"page-header\">
    <h2>";
        // line 2
        echo twig_escape_filter($this->env, ($context["form_header"] ?? null), "html", null, true);
        echo "</h2>
</div>
<form class=\"form-horizontal\" id=\"form_element\" type=\"submit\" submit=\"event.preventDefault(); saveElement();\">
    <input type=\"text\" class=\"form-control\" name=\"id\" id=\"id\" style=\"display: none;\" value=";
        // line 5
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo ">
    <div class=\"form-group code\">
        <label for=\"recipient-name\" class=\"control-label col-sm-1\">Code</label>
        <div class=\"col-sm-11\">
            <input type=\"text\" class=\"form-control\" name=\"code\" id=\"code\" value=";
        // line 9
        echo twig_escape_filter($this->env, ($context["code"] ?? null), "html", null, true);
        echo ">
        </div>
    </div>
    <div class=\"form-group\">
        <label for=\"text\" class=\"control-label col-sm-1\">Name:</label>
        <div class=\"col-sm-11\">
            <input class=\"form-control\" name = \"name\" id=\"name\" value= ";
        // line 15
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo ">
        </div>
    </div>
    <div class=\"form-group\">
        <label for=\"text\" class=\"control-label col-sm-1\">Short name:</label>
        <div class=\"col-sm-11\">
            <input class=\"form-control\" name=\"short_name\" id=\"short_name\" value=";
        // line 21
        echo twig_escape_filter($this->env, ($context["short_name"] ?? null), "html", null, true);
        echo ">
        </div>
    </div>
    
    ";
        // line 25
        $this->loadTemplate("form_buttons_footer.twig", "form_currency_element.html.twig", 25)->display($context);
        echo "  
    <div id=\"alertbox\" class=\"alert alert-warning alert-dismissible\" role=\"alert\" style=\"display: none\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
    <div id=\"error_list\">
        
    </div>
    </div>
</form>
    
";
    }

    public function getTemplateName()
    {
        return "form_currency_element.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 25,  53 => 21,  44 => 15,  35 => 9,  28 => 5,  22 => 2,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "form_currency_element.html.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\currency\\form_currency_element.html.twig");
    }
}
