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
        return $this->loadTemplate(((($context["isNotAjax"] ?? null)) ? (($context["layout"] ?? null)) : ("")), "tmpl_signup.twig", 2);
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
<div class=\"section\">
    
    <h4><span class=\"card-title thin grey-text text-darken-4\">Welcome to Personal finance system!</span></h4>
    <div class=\"section\">
    <h5><span class=\"card-title thin grey-text text-darken-4\">Please, fill registration form!</span></h5>
</div>
    
</div>



<div class=\"row\">
<div class=\"col s12 m12 l12 xl12 \">
<div class=\"card login-wrapper\">
<div class=\"card-content hoverable\">
<form action='/user/signup' method='post'>
<input name=\"csrf_token\" type=\"hidden\" value=\"";
        // line 21
        echo twig_escape_filter($this->env, ($context["csrf_token"] ?? null), "html", null, true);
        echo "\"> 
  <div class=\"input-field\">
    <i class=\"material-icons prefix\">account_circle</i>
    <label for=\"InputName\">Your name</label>
    <input type=\"text\" name=\"name\" class=\"form-control\" id=\"InputName\" placeholder=\"Enter name\" value = ";
        // line 25
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo ">
  </div>
    
   <div class=\"input-field\">
    <i class=\"material-icons prefix\">email</i>
    <label for=\"exampleInputEmail1\">Email address</label>
    <input type=\"email\" name=\"login\" class=\"form-control\" id=\"InputEmail1\" aria-describedby=\"emailHelp\" placeholder=\"Enter email\" value = ";
        // line 31
        echo twig_escape_filter($this->env, ($context["login"] ?? null), "html", null, true);
        echo ">
  </div>
  <div class=\"input-field\">
      <i class=\"material-icons prefix\">https</i>
    <label for=\"exampleInputPassword1\">Password</label>
    <input type=\"password\" name=\"password\" class=\"form-control\" id=\"InputPassword1\" placeholder=\"Password\">
  </div>
    ";
        // line 39
        echo "    ";
        if (($context["error"] ?? null)) {
            // line 40
            echo "           
    <div class=\"alert alert-danger\" role=\"alert\">
        ";
            // line 42
            echo ($context["error"] ?? null);
            echo "
    </div>
    ";
        }
        // line 45
        echo "    ";
        // line 46
        echo "   
    <button type=\"submit\" name=\"buttonregister\" class=\"btn waves-effect waves-light light-green darken-2\"><i class=\"material-icons left\">send</i>Sign up</button>

</form>
</div>
</div>
</div>
</div>
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
        return array (  90 => 46,  88 => 45,  82 => 42,  78 => 40,  75 => 39,  65 => 31,  56 => 25,  49 => 21,  30 => 4,  27 => 3,  18 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "tmpl_signup.twig", "C:\\OSPanel\\domains\\localhost\\pf\\Views\\user\\tmpl_signup.twig");
    }
}
