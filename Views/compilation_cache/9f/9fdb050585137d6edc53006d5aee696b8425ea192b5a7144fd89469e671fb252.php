<?php

/* currency_list_data.twig */
class __TwigTemplate_244aad92c5068e796f5f5c49387edcebc6bf362d587a6acad920c3ee5c10a321 extends Twig_Template
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
            echo "    <tr name=\"tr_1\" id=\"tr_1\">
          <td class=\"hidden\">";
            // line 3
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "id", array()), "html", null, true);
            echo "</td>
          <td dblclick=\"AddNew();\">";
            // line 4
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "code", array()), "html", null, true);
            echo "</td>
          <td>";
            // line 5
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "name", array()), "html", null, true);
            echo "</td>
          <td>";
            // line 6
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["element"], "short_name", array()), "html", null, true);
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
        return "currency_list_data.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  34 => 5,  30 => 4,  26 => 3,  23 => 2,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "currency_list_data.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\currency\\currency_list_data.twig");
    }
}
