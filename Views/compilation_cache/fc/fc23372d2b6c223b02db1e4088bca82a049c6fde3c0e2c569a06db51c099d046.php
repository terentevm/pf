<?php

/* login.php */
class __TwigTemplate_f8f4417cbf01ec9eea91101a0d9abf814541590917ac2e1d31b4ecfc8e1f4723 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("main.twig", "login.php", 1);
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

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "<div class=\"page-header\">
    <h3>Please, login to enter!</h3>
</div>
<?php if(isset(\$_SESSION['error'])):?>
           
<div class=\"alert alert-danger\" role=\"alert\">
<?= \$_SESSION['error']?>
</div>
<?php endif;?>
<?php if(isset(\$_SESSION['error'])) unset(\$_SESSION['error'])?>
<form action='/user/login' method='post'>

    <input name=\"csrf_token\" type=\"hidden\" value=\"<?= \$_SESSION['csrf_token'] ?>\"> 
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
        return "login.php";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 3,  28 => 2,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "login.php", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\templates\\login.php");
    }
}
