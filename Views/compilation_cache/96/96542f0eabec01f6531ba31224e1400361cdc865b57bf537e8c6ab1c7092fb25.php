<?php

/* tmpl_signup.twig */
class __TwigTemplate_f3e37b45dd401fbbd6343a3af7c8c4f82195c010c476af4e418ff16ac0c74eae extends Twig_Template
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
        // line 2
        return $this->loadTemplate(((($context["isNotAjax"] ?? null)) ? ("main.twig") : ("")), "tmpl_signup.twig", 2);
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

<div class=\"page-header\">
    <h2>Please fill registration form!</h2>
</div>

";
        // line 11
        if (($context["error"] ?? null)) {
            // line 12
            echo "           
<div class=\"alert alert-danger\" role=\"alert\">
    ";
            // line 14
            echo ($context["error"] ?? null);
            echo "
</div>
";
        }
        // line 18
        echo "
<form action='/user/signup' method='post'>
<input name=\"csrf_token\" type=\"hidden\" value=\"";
        // line 20
        echo twig_escape_filter($this->env, ($context["csrf_token"] ?? null), "html", null, true);
        echo "\"> 
  <div class=\"form-group\">
    <label for=\"InputName\">Your name</label>
    <input type=\"text\" name=\"name\" class=\"form-control\" id=\"InputName\" placeholder=\"Enter name\" value = ";
        // line 23
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo ">
  </div>
    
   <div class=\"form-group\">
    <label for=\"exampleInputEmail1\">Email address</label>
    <input type=\"email\" name=\"login\" class=\"form-control\" id=\"InputEmail1\" aria-describedby=\"emailHelp\" placeholder=\"Enter email\" value = ";
        // line 28
        echo twig_escape_filter($this->env, ($context["login"] ?? null), "html", null, true);
        echo ">
  </div>
  <div class=\"form-group\">
    <label for=\"exampleInputPassword1\">Password</label>
    <input type=\"password\" name=\"password\" class=\"form-control\" id=\"InputPassword1\" placeholder=\"Password\">
  </div>

    <button type=\"submit\" name=\"buttonregister\" class=\"btn btn-primary active\">Register</button>
</form>

";
    }

    public function getTemplateName()
    {
        return "tmpl_signup.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 28,  60 => 23,  54 => 20,  50 => 18,  44 => 14,  40 => 12,  38 => 11,  30 => 4,  27 => 3,  18 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "tmpl_signup.twig", "C:\\Apache\\Apache24\\htdocs\\pf\\Views\\user\\tmpl_signup.twig");
    }
}
