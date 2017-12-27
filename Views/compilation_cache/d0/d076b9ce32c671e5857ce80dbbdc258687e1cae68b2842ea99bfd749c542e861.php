<?php

/* settings.twig */
class __TwigTemplate_53dead9b125f8bd2b75f8a56b063a95433fe36bb19b031b13e4436658a818eae extends Twig_Template
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
        return $this->loadTemplate(($context["layout"] ?? null), "settings.twig", 1);
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
    
    <h3 class=\"header thin grey-text text-darken-4\"><i class=\" medium material-icons\">settings</i> Settings</h3>
    
    <section>
      <h4 class=\"header thin grey-text text-darken-4\"><span>References</span></h4>   
    </section>
   

<div class=\"row\">
    <div class=\"col s12 m6 l6 xl6\">
     <div class=\"card  horizontal hoverable\">
        <div class=\"card-image\">
            <i class=\"material-icons medium\">queue</i>
        </div>
         <div class=\"card-stacked\">
            <div class=\"card-action\"> 
                <a href=\"/RefIncome/GetList\">Income items</a>
            </div> 
        </div> 
     </div> 
    </div>
    
    <div class=\"col s12 m6 l6 xl6\">
     <div class=\"card horizontal hoverable\">
        <div class=\"card-image\">
            <i class=\"material-icons medium\">euro_symbol</i>
        </div>
         <div class=\"card-stacked\">
            <div class=\"card-action\"> 
                <a href=\"/Currency/GetList\">Currencies</a>
            </div> 
        </div> 
     </div> 
    </div>
</div>

<div class=\"row\">
    <div class=\"col s12 m6 l6 xl6\">
     <div class=\"card horizontal hoverable\">
        <div class=\"card-image\">
            <i class=\"material-icons medium\">local_grocery_store</i>
        </div>
         <div class=\"card-stacked\">
            <div class=\"card-action\"> 
                <a href=\"/RefExpenditure/GetList\">Expenditure items</a>
            </div> 
        </div> 
     </div> 
    </div>
    
    <div class=\"col s12 m6 l6 xl6\">
     <div class=\"card horizontal hoverable\">
        <div class=\"card-image\">
            <i class=\"material-icons medium\">account_balance_wallet</i>
        </div>
         
        <div class=\"card-stacked\">

            <div class=\"card-action\">
                <a href=\"/Wallets/GetList\">Wallets</a>
            </div>
        </div>
         
     </div> 
    </div>
</div>

    <section>
        <h4 class=\"header thin grey-text text-darken-4\"><span>Tools</span></h4>   
    </section>

    <div class=\"col s12 m12 l12 xl2\">
        <div class=\"card horizontal hoverable\">
            <div class=\"card-image\">
                <i class=\"material-icons medium\">settings_applications</i>
            </div>

            <div class=\"card-stacked\">

                <div class=\"card-action\">
                    <a href=\"/tools/program_settings\">Program settings</a>
                </div>
            </div>

        </div> 
    </div>
    
    <div class=\"col s12 m12 l12 xl2\">
        <div class=\"card horizontal hoverable\">
            <div class=\"card-image\">
                <i class=\"material-icons medium\">import_export</i>
            </div>

            <div class=\"card-stacked\">

                <div class=\"card-action\">
                    <a href=\"/tools/import1c\">Import from 1C:Money</a>
                </div>
            </div>

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
        return array (  30 => 4,  27 => 3,  18 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "settings.twig", "E:\\OSPanel\\domains\\localhost\\pf\\Views\\templates\\settings.twig");
    }
}
