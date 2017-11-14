<?php

/* tmpl_wallets_list_data.twig */
class __TwigTemplate_2f329a24334caf2b7d7285fe2706fb0ca8269225399f3cf60f4b0f703e29d053 extends Twig_Template
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
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["vars"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["element"]) {
            // line 2
            echo "    <tr name=\"tr_1\" id=\"tr_1\" data-href= \"/wallets/GetElement/?";
            echo twig_escape_filter($this->env, twig_urlencode_filter(array("id" => twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "id", array()))), "html", null, true);
            echo "\">
          <td class=\"hide\">";
            // line 3
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "id", array()), "html", null, true);
            echo "</td>
          <td dblclick=\"AddNew();\"><a href= \"/wallets/GetElement/?";
            // line 4
            echo twig_escape_filter($this->env, twig_urlencode_filter(array("id" => twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "id", array()))), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "name", array()), "html", null, true);
            echo "</a></td>
          <td>";
            // line 5
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "dic_currency_short_name", array()), "html", null, true);
            echo "</td>
          <td class=\"visible-md visible-lg\">";
            // line 6
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "is_creditcard", array()), "html", null, true);
            echo "</td>
      </tr>  
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['element'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "tmpl_wallets_list_data.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 6,  38 => 5,  32 => 4,  28 => 3,  23 => 2,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "tmpl_wallets_list_data.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\wallets\\tmpl_wallets_list_data.twig");
    }
}
