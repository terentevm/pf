<?php

/* form_currency_element.html.twig */
class __TwigTemplate_bc8c98158ab03d874095f7e3b92df48d45c2bfd92153e3ecf933d96ec3142946 extends Twig_Template
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
    <h2>New currency</h2>
</div>
<form id=\"form_element\" type=\"submit\" submit=\"event.preventDefault(); saveElement();\">
    <input type=\"text\" class=\"form-control\" name=\"id\" id=\"id\" style=\"display: none;\" value=";
        // line 5
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo ">
    <div class=\"form-group code\">
        <label for=\"recipient-name\" class=\"control-label\">Code</label>
        <input type=\"text\" class=\"form-control\" name=\"code\" id=\"code\" value=";
        // line 8
        echo twig_escape_filter($this->env, ($context["code"] ?? null), "html", null, true);
        echo ">
    </div>
    <div class=\"form-group\">
        <label for=\"text\" class=\"control-label\">Name:</label>
        <input class=\"form-control\" name = \"name\" id=\"name\" value=";
        // line 12
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo ">
    </div>
    <div class=\"form-group\">
        <label for=\"text\" class=\"control-label\">Short name:</label>
        <input class=\"form-control\" name=\"short_name\" id=\"short_name\" value=";
        // line 16
        echo twig_escape_filter($this->env, ($context["short_name"] ?? null), "html", null, true);
        echo ">
    </div>
    
    <div class=\"form-group\">
        <button type =\"submit\" class =\"btn btn-primary\" >Save</button>
        <button type =\"reset\" class =\"btn btn-warning\">Cancel</button>
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
        return array (  45 => 16,  38 => 12,  31 => 8,  25 => 5,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "form_currency_element.html.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\templates\\forms\\form_currency_element.html.twig");
    }
}
