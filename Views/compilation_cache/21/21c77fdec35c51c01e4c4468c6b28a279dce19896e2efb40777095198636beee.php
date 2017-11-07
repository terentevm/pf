<?php

/* currency_list_data.twig */
class __TwigTemplate_8b2529fbd2fa293c123a2905e67ebe6d5bddb3950510fe8bf402b4c324ccf899 extends Twig_Template
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
            echo "    <tr id=\"tr_1\">
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
        return new Twig_Source("", "currency_list_data.twig", "E:\\OSPanel\\domains\\localhost\\pf\\Views\\templates\\forms\\currency_list_data.twig");
    }
}
