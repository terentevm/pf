<?php

/* wallets_list.twig */
class __TwigTemplate_e7932da69671e412221868949fe8052059650148960be20d434a4d6f9922becb extends Twig_Template
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
        echo twig_escape_filter($this->env, ($context["head_title"] ?? null), "html", null, true);
        echo "</h2>
</div>
";
    }

    public function getTemplateName()
    {
        return "wallets_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 2,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "wallets_list.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\templates\\wallets_list.twig");
    }
}
