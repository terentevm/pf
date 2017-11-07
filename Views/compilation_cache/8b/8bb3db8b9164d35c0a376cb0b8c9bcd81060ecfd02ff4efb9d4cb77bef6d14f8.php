<?php

/* index.twig */
class __TwigTemplate_7b25b15e85958015d4abb3e423181edfa8c342c97ea5d01f1667d29a7eb1e8bf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("main.twig", "index.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "main.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "<div class =\"container\">
    
    <div class=\"panel panel-default\">
        <div class=\"panel-heading\"><?= \$post['email'] ?></div>
        <div class=\"panel-body\">
            <h1>ВЫ ВОШЛИ</h1>
        </div>
    </div>

</div>
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
        return array (  31 => 4,  28 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\templates\\index.twig");
    }
}
