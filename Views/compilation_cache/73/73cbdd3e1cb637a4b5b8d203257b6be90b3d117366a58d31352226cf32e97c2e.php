<?php

/* currency_list.twig */
class __TwigTemplate_fc0722e93634bc8f6dde5b5ebde9948d1d73e20f58be3407b2b75dab935fb9f3 extends Twig_Template
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
        return $this->loadTemplate(($context["layout"] ?? null), "currency_list.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "    <div id=\"frame\">
<div class=\"page-header\">
    <h2>Currencies</h2>
</div>
<form id =\"form\">
    <div class=\"form-group\">
    <button class=\"btn btn-primary\" id=\"btn_curr_update\" onclick=\"getData(); return false;\">Update</button>
    <button class=\"btn btn-primary\" id=\"btn_curr_new\" data-whatever=\"@mdo\" onclick=\"AddNew(); return false;\">Add</button>
    </div>
    <div class=\"table-responsive\">
    <div class=\"row\"></div>
    <table class=\"table bordered table-hover highlight\">
      <tr class=\"spr_list_head\">
          <th class=\"hide\">id</th>
          <th>Code</th>
          <th>Name</th>
          <th>Short name</th>
      </tr>
      <tbody id=\"tbody\">
          
      </tbody>  
  </table>
</div>
</form> 
</div>

";
    }

    public function getTemplateName()
    {
        return "currency_list.twig";
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
        return new Twig_Source("", "currency_list.twig", "E:\\OSPanel\\domains\\localhost\\pf\\Views\\currency\\currency_list.twig");
    }
}
