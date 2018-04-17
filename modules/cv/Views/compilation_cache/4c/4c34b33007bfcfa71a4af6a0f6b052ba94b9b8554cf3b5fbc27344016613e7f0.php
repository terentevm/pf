<?php

/* index.twig */
class __TwigTemplate_e08ed839685f752ce7013ccf0e54f15f502e526bd057e1a769e159e41c8b598e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return $this->loadTemplate(($context["layout"] ?? null), "index.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 4,  27 => 3,  18 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.twig", "C:\\OSPanel\\domains\\localhost\\pf\\modules\\cv\\Views\\main\\index.twig");
    }
}
