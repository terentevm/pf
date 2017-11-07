<?php

/* login.twig */
class __TwigTemplate_b959148db06d40e4ea9dd85c119063b42964e4ce56d1ed49d11911488a19d3fa extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("main.twig", "login.twig", 1);
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
        echo "<div class=\"page-header\">
    <h3>Please, login to enter!</h3>
</div>
";
        // line 8
        if (($context["error"] ?? null)) {
            // line 9
            echo "           
<div class=\"alert alert-danger\" role=\"alert\">
    ";
            // line 11
            echo ($context["error"] ?? null);
            echo "
</div>
";
        }
        // line 15
        echo "<form action='/user/login' method='post'>

    <input name=\"csrf_token\" type=\"hidden\" value=\"";
        // line 17
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

    <button type=\"submit\" name=\"buttonregister\" class=\"btn btn-primary\">Login</button>
    <a class=\"btn btn-primary active\" href=\"/user/signup\">Register new user</a>
</form>
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
        return array (  52 => 17,  48 => 15,  42 => 11,  38 => 9,  36 => 8,  31 => 4,  28 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "login.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\templates\\login.twig");
    }
}
