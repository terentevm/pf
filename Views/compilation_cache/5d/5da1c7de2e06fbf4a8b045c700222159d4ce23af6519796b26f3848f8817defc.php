<?php

/* tmpl_wallets_list.twig */
class __TwigTemplate_50fa54fc237895cb22e52b050a004db9fb65cf7da0d791762f855f839d7924e1 extends Twig_Template
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
        return $this->loadTemplate(($context["layout"] ?? null), "tmpl_wallets_list.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "<div id=\"frame\">

    <h2 class=\"header thin\">Wallets</h2>

<form id =\"form\">
    <div class=\"form-group\">
    <a href=\"/wallets/getelement\" class=\"right btn-floating btn-large waves-effect waves-light red\" id =\"btn_wallet_new\"><i class=\"material-icons\">add</i></a>
    <button class=\"right btn-floating btn-large waves-effect waves-light yellow\" id=\"btn_curr_update\" onclick=\"getData(); return false;\"><i class=\"material-icons\">sync</i></button>
   
    </div>
    
    <table class=\"bordered\">
      <tr class=\"spr_list_head\">
          <th class=\"hide\">id</th>
          <th>Name</th>
          <th>Currency</th>
          <th class=\"visible-md visible-lg\">Is credit card</th>
      </tr>
      <tbody id=\"tbody\">
      ";
        // line 23
        $this->loadTemplate("tmpl_wallets_list_data.twig", "tmpl_wallets_list.twig", 23)->display($context);
        echo "    
      </tbody>  
  </table>

</form> 
</div>

";
    }

    public function getTemplateName()
    {
        return "tmpl_wallets_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 23,  30 => 4,  27 => 3,  18 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "tmpl_wallets_list.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\wallets\\tmpl_wallets_list.twig");
    }
}
