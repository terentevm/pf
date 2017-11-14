<?php

/* login.twig */
class __TwigTemplate_90c0741de61ee493223e375f738affeade42ac8da7552ff8903732a9bc03138f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("material.twig", "login.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "material.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
";
        // line 6
        if (($context["error"] ?? null)) {
            // line 7
            echo "           
<div class=\"alert alert-danger\" role=\"alert\">
    ";
            // line 9
            echo ($context["error"] ?? null);
            echo "
</div>
";
        }
        // line 13
        echo "<div class=\"row\">
<div class=\"col s12 m12 l12 xl12 \">
<div class=\"card login-wrapper\">
<div class=\"card-content hoverable\">
<form  action='/user/login' method='post'>
 <span class=\"card-title grey-text text-darken-4\">Please, login for enter!</span>
    <input name=\"csrf_token\" type=\"hidden\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, ($context["csrf_token"] ?? null), "html", null, true);
        echo "\"> 
   <div class=\"form-group\">
    <label for=\"exampleInputEmail1\">Email address</label>
    <input type=\"email\" name=\"login\" class=\"form-control\" id=\"InputEmail1\" aria-describedby=\"emailHelp\" placeholder=\"Enter email\">
  </div>
  <div class=\"form-group\">
    <label for=\"exampleInputPassword1\">Password</label>
    <input type=\"password\" name=\"password\" class=\"form-control\" id=\"InputPassword1\" placeholder=\"Password\">
  </div>

    <button type=\"submit\" name=\"buttonregister\" class=\"btn-floating btn-large waves-effect waves-light light-green darken-2\"><i class=\"material-icons\">send</i></button>
    <a class=\"btn-floating btn-large waves-effect waves-light amber darken-1\" href=\"/user/signup\"><i class=\"material-icons right\">add</i></a>
</form>
</div>
</div>
</div>
</div>
";
    }

    public function getTemplateName()
    {
        return "login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 19,  46 => 13,  40 => 9,  36 => 7,  34 => 6,  31 => 4,  28 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "login.twig", "C:\\Apache\\Apache24\\htdocs\\pf\\Views\\user\\login.twig");
    }
}
