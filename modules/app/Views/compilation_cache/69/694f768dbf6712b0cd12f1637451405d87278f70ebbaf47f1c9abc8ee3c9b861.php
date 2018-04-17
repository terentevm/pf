<?php

/* tmpl_wallets_element.twig */
class __TwigTemplate_ccf5479da235eaaea2328e97e1c625781f4a7b42f967464c57b78429dc6b78a7 extends Twig_Template
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
        return $this->loadTemplate(((($context["isNotAjax"] ?? null)) ? (($context["layout"] ?? null)) : ("")), "tmpl_wallets_element.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "<div class=\"page-header\">
    <h2>";
        // line 4
        echo twig_escape_filter($this->env, ($context["form_header"] ?? null), "html", null, true);
        echo "</h2>
</div>

<form class=\"form-horizontal\" id=\"wallet_form\" name =\"wallet_form\" method=\"post\" action=\"/Wallets/SaveElement\">
<input name=\"csrf_token\" type=\"hidden\" value=\"";
        // line 8
        echo twig_escape_filter($this->env, ($context["csrf_token"] ?? null), "html", null, true);
        echo "\"> 
<input type=\"text\" class=\"form-control\" name=\"id\" id=\"id\" style=\"display: none;\" value=";
        // line 9
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo ">
    
<div class=\"form-group\">
    
    <label class=\"control-label col-sm-1\" for=\"name\">Name</label>    

    <div class=\"col-sm-11\">
    <input class=\"form-control\" type=\"text\" id=\"name\" name=\"name\" value = \"";
        // line 16
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo "\">   
    </div>
     
    
</div>

<div class=\"form-group\">

    <label class=\"control-label col-sm-1\" for=\"currency_id\">Currency</label>    

    <div class=\"col-sm-11\">
        <select class=\"form-control\" id = \"currency_id\" name=\"currency_id\">
            ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["currency_list"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["currency"]) {
            // line 29
            echo "                ";
            if ((twig_get_attribute($this->env, $this->getSourceContext(), $context["currency"], "id", array()) == ($context["currency_id"] ?? null))) {
                // line 30
                echo "                    <option selected value=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["currency"], "id", array()), "html", null, true);
                echo "\" >";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["currency"], "short_name", array()), "html", null, true);
                echo " </option>
                ";
            } else {
                // line 32
                echo "                    <option value=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["currency"], "id", array()), "html", null, true);
                echo "\" >";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["currency"], "short_name", array()), "html", null, true);
                echo " </option>
                ";
            }
            // line 34
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['currency'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "        </select>
    </div>
</div>
";
        // line 39
        echo "<div class=\"form-group\">
<div class=\"col-sm-offset-1 col-sm-11\">
      <div class=\"checkbox\">
        <label>
          <input type=\"checkbox\" id=\"is_creditcard\" name=\"is_creditcard\" ";
        // line 43
        echo ($context["is_checked"] ?? null);
        echo " value = \"1\"> Is credit card
        </label>
      </div>
    </div>   
</div>
";
        // line 49
        echo "<div class=\"form-group\">
 
    <label class=\"control-label col-sm-1\" for=\"credit_limit\">Credit limit</label>    

    <div class=\"col-sm-11\">
    <input class=\"form-control\" type=\"number\" step =\"0.01\" id=\"credit_limit\" name=\"credit_limit\" value = ";
        // line 54
        echo twig_escape_filter($this->env, ($context["credit_limit"] ?? null), "html", null, true);
        echo ">   
    </div>
     
    
</div>
    
 <div class=\"form-group\">
   
    <label class=\"control-label col-sm-1\" for=\"grace_period\">Grace period</label>    

    <div class=\"col-sm-11\">
    <input class=\"form-control\" type=\"number\" id=\"grace_period\" name=\"grace_period\" value = ";
        // line 65
        echo twig_escape_filter($this->env, ($context["grace_period"] ?? null), "html", null, true);
        echo ">   
    </div>
      
</div>
    ";
        // line 69
        $this->loadTemplate("form_buttons_footer.twig", "tmpl_wallets_element.twig", 69)->display($context);
        echo "   
</form>
    
";
    }

    public function getTemplateName()
    {
        return "tmpl_wallets_element.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  145 => 69,  138 => 65,  124 => 54,  117 => 49,  109 => 43,  103 => 39,  98 => 35,  92 => 34,  84 => 32,  76 => 30,  73 => 29,  69 => 28,  54 => 16,  44 => 9,  40 => 8,  33 => 4,  30 => 3,  27 => 2,  18 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "tmpl_wallets_element.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\wallets\\tmpl_wallets_element.twig");
    }
}
