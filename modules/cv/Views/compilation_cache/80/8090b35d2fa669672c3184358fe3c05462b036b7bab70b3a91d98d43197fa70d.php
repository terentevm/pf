<?php

/* main.twig */
class __TwigTemplate_dd2012c26894c0d1b6d68d498354d2d35357239b564b2d5a88de45b4a2074b5f extends Twig_Template
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
        echo "<!DOCTYPE html>
<html lang=\"en\" style=\"height: 100%\">

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <title>Mikhail Terentev CV</title>
    <link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">
    <link type=\"text/css\" rel=\"stylesheet\" href=\"/public/css/materialize.min.css\" />
    <link type=\"text/css\" rel=\"stylesheet\" href=\"/public/css/cv.css\" />
    <link type=\"text/css\" rel=\"stylesheet\" href=\"/public/css/font-awesome.min.css\" />

</head>

<body>
 
<ul id=\"dropdown1\" class=\"dropdown-content blue-text text-darken-2\">
    <li class=\"collection-item avatar\">
        
            <a href=\"?lang=cs\">
                <svg class=\"flag\">
                    <use xlink:href=\"/public/img/flags.svg#icon-flag-cs\"></use>
                </svg>
            </a>
            
        
    </li>
  <li class=\"collection-item\">
    <a href=\"?lang=en\">
            <svg class=\"flag\">
                <use xlink:href=\"/public/img/flags.svg#icon-flag-en\"></use>
            </svg>
        </a>
    </li>
  <li class=\"divider\"></li>
  <li class=\"collection-item\">
    <a href=\"?lang=ru\">
            <svg class=\"flag\">
                <use xlink:href=\"/public/img/flags.svg#icon-flag-ru\"></use>
            </svg>
        </a>
    </li>
</ul>
<nav class =\"white hide-on-large-only blue-text text-darken-2\">
  <div class=\"nav-wrapper blue-text text-darken-2\">
  <a href=\"#\" data-target=\"slide-out\" class=\"sidenav-trigger button-collapse  hide-on-large-only\">
        
        <img style=\"margin:20%;\" src=\"/public/img/menu.svg\"></img>

            
        </a>
    <ul class=\"right blue-text text-darken-2\">

     <li>
            <a class='dropdown-trigger' href='#!' data-target='dropdown1' style='color: black'> 
                <svg class='flag'>
                        <use xlink:href= ";
        // line 58
        echo twig_escape_filter($this->env, ($context["flag"] ?? null), "html", null, true);
        echo "></use>
                    </svg>
                </a>
            </li>
     
    </ul>
  </div>
</nav>
    <ul id=\"slide-out\" class=\"sidenav sidenav-fixed\">

        ";
        // line 68
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["sideMenu"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["list_item"]) {
            // line 69
            echo "            <li>
            <a href=\"#personal\" class=\"scroll \"><span class=\"menu-item\">";
            // line 70
            echo twig_escape_filter($this->env, $context["list_item"], "html", null, true);
            echo "</span></a>
            </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['list_item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 72
        echo "             
      

    </ul>

    

    <div class=\"container\">
        <section class=\"panel examples\" data-section-name=\"personal\">
            <span><h2>Personal data</h2></span>
            <div class=\"row\">
                <div class=\"card\">
                          
                            
                <div class=\"col s12 m6 l6\">
                    <table>
                        <tr>
                            <td>Name:</td>
                            <td>Mikhail Terentev</td>
                        </tr>
                        <tr>
                            <td>Telephone:</td>
                            <td>+79263238900</td>
                        </tr>
                        <tr>
                            <td>E-Mail</td>
                            <td>terentievma@mail.ru</td>
                        </tr>
                        <tr>
                            <td>Date og birth</td>
                            <td>01-05-1987</td>
                        </tr>
                        <tr>
                            <td>Nationality</td>
                            <td>Russian</td>
                        </tr>
                    </table>
                </div>
                <div class=\"col s12 m6 l6\">
                    <div class=\"card-image\" >
                        <img src=\"/public/img/foto.jpg\" weight=\"300\" height=\"300\">
                    </div>  
                </div>
            </div>
            </div>
                 
        </section>
        
        <section class=\"panel examples\" data-section-name=\"profile\">
            <h2>Profile</h2>
            <div class=\"row\">
                    <p class=\"flow-text\">
                            I'm working as a programmer (1C:Enterprise) in Moscow and i'd like to move on to Czech republic and start working as web programmer. Now i'm studying PHP and JavaScript by myself (online lessons and books). As a training project, i'm developing personal finance system (in process). 
                            Backend has written in PHP, frontend Vue.js with vuetify css framework.
                        
                    
                    </p>
            </div>
            
            <div class=\"row\">
                    <a href=\"http://github.com/terentevm\" target=\"_blank\">
                        <i class=\" fa  fa-github  fa-2x \" title=\"Github\"> My Github</i>
                    </a>   
            </div>

            <div class=\"row\">
                    <a href=\"https://1c-dn.com/1c_enterprise\" target=\"_blank\">
                        About 1C
                    </a>
            </div>
            
            
            
        </section>
        
        <section class=\"panel examples\" data-section-name=\"education\">

        </section>
        
        <section class=\"panel examples\" data-section-name=\"employment\">
            <h2>My employment history</h2>
            <div class=\"row\">
                <div class=\"card hoverable\">
                    <h3 class=\" grey-text text-darken-4\">Company: Ostec LLC</h3>
            
                    <div class=\"card-content\">
                        <h5 class=\"grey-text text-darken-4\">01/2015 – present</h5>
                        <h5 class=\"grey-text text-darken-4\">Position: Programmer 1C</h5>
                        <h5 class=\"grey-text text-darken-4\">Responsibilities:</h5>
                        <p class=\"caption\">
                            Development on 1C:Enterprise platform. Main direction – is managerial financial accounting.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class=\"row\">
                <div class=\"card hoverable\">
                    <h3 class=\" grey-text text-darken-4\">Company: Magistral-NN LLC</h3>
            
                    <div class=\"card-content\">
                        <h5 class=\"grey-text text-darken-4\">08/2013 – 12/2015</h5>
                        <h5 class=\"grey-text text-darken-4\">Position: Programmer 1C</h5>
                        <h5 class=\"grey-text text-darken-4\">Responsibilities:</h5>
                        <p class=\"caption\">
                            Development on 1C:Enterprise platform. The main direction of development is trade subsystem and exchanging with an online
                            store.
                        </p>
                    </div>
                </div>
            </div>

            <div class=\"row\">
                    <div class=\"card hoverable\">
                        <h3 class=\" grey-text text-darken-4\">Company: Selecta LLC</h3>
                
                        <div class=\"card-content\">
                            <h5 class=\"grey-text text-darken-4\">04/2010 – 08/2013</h5>
                            <h5 class=\"grey-text text-darken-4\">Position: Programmer 1C (started as a junior programmer)</h5>
                            <h5 class=\"grey-text text-darken-4\">Responsibilities:</h5>
                            <p class=\"caption\">
                                    Development and consulting of external clients. The main direction of development is accounting, trade and production.
                            </p>
                        </div>
                    </div>
                </div>
        </section>
        
        <section class=\"panel examples\" data-section-name=\"skills\">

        </section>

    </div>
    <script src=\"https://code.jquery.com/jquery-3.2.1.min.js\"></script>
    <script type=\"text/javascript\" src=\"/public/js/materialize.min.js\"></script>
</body>

<script>

\$(document).ready(function(){
    \$('.sidenav').sidenav();
    \$(\".dropdown-trigger\").dropdown();
        
});

</script>


</html>";
    }

    public function getTemplateName()
    {
        return "main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 72,  98 => 70,  95 => 69,  91 => 68,  78 => 58,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "main.twig", "C:\\OSPanel\\domains\\localhost\\pf\\modules\\cv\\Views\\Layouts\\main.twig");
    }
}
