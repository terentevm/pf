<?php

/* tmpl_wallets_list.twig */
class __TwigTemplate_50fa54fc237895cb22e52b050a004db9fb65cf7da0d791762f855f839d7924e1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("main.twig", "tmpl_wallets_list.twig", 1);
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
        echo "    <div id=\"frame\">
<div class=\"page-header\">
    <h2>Wallets</h2>
</div>
<form id =\"form\">
    <div class=\"form-group\">
    <a href=\"/wallets/getelement\" class=\"btn btn-primary\" id =\"btn_wallet_new\">Add</a>
    <button class=\"btn btn-primary\" id=\"btn_curr_update\" onclick=\"getData(); return false;\">Update</button>
   
    </div>
    <div class=\"table-responsive\">
    <div class=\"row\"></div>
    <table class=\"table table-bordered table-hover\">
      <tr class=\"spr_list_head\">
          <th class=\"hidden\">id</th>
          <th>Name</th>
          <th>Currency</th>
          <th class=\"visible-md visible-lg\">Is credit card</th>
      </tr>
      <tbody id=\"tbody\">
      ";
        // line 24
        $this->loadTemplate("tmpl_wallets_list_data.twig", "tmpl_wallets_list.twig", 24)->display($context);
        echo "    
      </tbody>  
  </table>
</div>
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
        return array (  53 => 24,  31 => 4,  28 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "tmpl_wallets_list.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\wallets\\tmpl_wallets_list.twig");
    }
}
