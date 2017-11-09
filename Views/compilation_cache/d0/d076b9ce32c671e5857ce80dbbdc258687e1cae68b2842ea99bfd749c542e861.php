<?php

/* settings.twig */
class __TwigTemplate_53dead9b125f8bd2b75f8a56b063a95433fe36bb19b031b13e4436658a818eae extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("main.twig", "settings.twig", 1);
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
        echo "<div class=\"page-header\">
    <h2>Settings</h2>
</div>    

<div class=\"row\">
    <div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">
        <h4><ins>Dictonaries</ins></h4>   
    </div>
</div>

<div class=\"row\">
    <div class=\"col-lg-6 col-md-6 col-sm-12 col-xs-12\">
        <ul class=\"border\">
            <li><a href=\"/Dictonaries/Income\">Income items</a></li>
            <li><a href=\"/Dictonaries/Expenditure\">Expenditure items</a></li>
            <li><a href=\"/Wallets/GetList\">Wallets</a></li>
        </ul>
    </div>
    <div class=\"col-lg-6 col-md-6 col-sm-12 col-xs-12\">
        <ul class=\"border\">
            <li><a href=\"/Currency/GetList\">Currencies</a></li>
        </ul>   
    </div>     
</div>
<div class=\"row\">
    <div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">
        <h4><ins>Tools</ins></h4>   
    </div>
</div>
<div class=\"row\">
    <div class=\"col-lg-6 col-md-6 col-sm-12 col-xs-12\">
        <ul class=\"border\">
            <li><a href=\"/tools/import1c\">Import from 1C:Money</a></li>
            <li><a href=\"/tools/program_settings\">Program settings</a></li>
           
        </ul>
    </div>
    <div class=\"col-lg-6 col-md-6 col-sm-12 col-xs-12\">
         
    </div>     
</div>    
";
    }

    public function getTemplateName()
    {
        return "settings.twig";
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
        return new Twig_Source("", "settings.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\templates\\settings.twig");
    }
}
