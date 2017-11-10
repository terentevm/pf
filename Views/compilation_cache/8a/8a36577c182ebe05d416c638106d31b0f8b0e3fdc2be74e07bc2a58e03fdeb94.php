<?php

/* login.twig */
class __TwigTemplate_90c0741de61ee493223e375f738affeade42ac8da7552ff8903732a9bc03138f extends Twig_Template
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
<<<<<<< HEAD
        echo "<div class=\"page-header\" style=\"vertical-align: middle;\">
    <div class=\"col-sm-1\" style=\"vertical-align: middle;\">
    <img class=\"img-rounded\" src=\"/public/src/login.png\"/>
    </div> 
    <div class=\"col-sm-11\" style=\"vertical-align: middle;\">
    <h3>Please, login to enter!</h3>
    </div> 
</div>
";
        // line 13
        if (($context["error"] ?? null)) {
            // line 14
            echo "           
<div class=\"alert alert-danger\" role=\"alert\">
    ";
            // line 16
=======
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
>>>>>>> e2acbbe78492b7cebfc680aa62a5c0cfd211e93c
            echo ($context["error"] ?? null);
            echo "
</div>
";
        }
<<<<<<< HEAD
        // line 20
        echo "<form action='/user/login' method='post'>

    <input name=\"csrf_token\" type=\"hidden\" value=\"";
        // line 22
=======
        // line 15
        echo "<form action='/user/login' method='post'>

    <input name=\"csrf_token\" type=\"hidden\" value=\"";
        // line 17
>>>>>>> e2acbbe78492b7cebfc680aa62a5c0cfd211e93c
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
<<<<<<< HEAD
        return array (  57 => 22,  53 => 20,  47 => 16,  43 => 14,  41 => 13,  31 => 4,  28 => 3,  11 => 1,);
=======
        return array (  52 => 17,  48 => 15,  42 => 11,  38 => 9,  36 => 8,  31 => 4,  28 => 3,  11 => 1,);
>>>>>>> e2acbbe78492b7cebfc680aa62a5c0cfd211e93c
    }

    public function getSourceContext()
    {
<<<<<<< HEAD
        return new Twig_Source("", "login.twig", "C:\\Apache\\Apache24\\htdocs\\pf\\Views\\user\\login.twig");
=======
        return new Twig_Source("", "login.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\user\\login.twig");
>>>>>>> e2acbbe78492b7cebfc680aa62a5c0cfd211e93c
    }
}
