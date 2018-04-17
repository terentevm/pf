<?php

/* form_buttons_footer.twig */
class __TwigTemplate_6cc4024ecdac2c787d6185d9b907d90af6dd212879de89e407ac9042bf12e270 extends Twig_Template
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
        echo "    <div class=\"form-group\">
        <div class=\"col-sm-offset-1 col-sm-11\">
            <button type =\"submit\" class =\"btn btn-primary\" id =\"btn_save\" name=\"btn_save\" >Save</button>
            <button id = \"btn_reset\" type =\"reset\" class =\"btn btn-warning\" name=\"btn_reset\">Cancel</button>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "form_buttons_footer.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "form_buttons_footer.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\templates\\form_buttons_footer.twig");
    }
}
