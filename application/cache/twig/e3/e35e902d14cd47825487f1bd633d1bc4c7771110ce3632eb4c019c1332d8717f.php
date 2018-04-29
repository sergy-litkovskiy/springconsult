<?php

/* layout.html.twig */
class __TwigTemplate_0f44a09138db61b8a3a3b9dad0e162e076c132231292e1394163efb20ada015c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
            'gift' => array($this, 'block_gift'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
    <!--[if IE 8 ]>
    <html class=\"ie ie8\" class=\"no-js\" lang=\"en\">
    <![endif]-->
    <!--[if (gte IE 9)|!(IE)]><!-->
    <html class=\"no-js\" lang=\"en\">
    <!--<![endif]-->
        <head>
            ";
        // line 9
        $this->displayBlock('head', $context, $blocks);
        // line 42
        echo "        </head>
        <body>
            ";
        // line 44
        $this->displayBlock('header', $context, $blocks);
        // line 78
        echo "
            ";
        // line 79
        $this->displayBlock('content', $context, $blocks);
        // line 80
        echo "
            ";
        // line 81
        $this->displayBlock('gift', $context, $blocks);
        // line 95
        echo "
            ";
        // line 96
        $this->displayBlock('footer', $context, $blocks);
        // line 101
        echo "        </body>
</html>";
    }

    // line 9
    public function block_head($context, array $blocks = array())
    {
        // line 10
        echo "                <meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
                <title>Spring Consulting - ";
        // line 13
        echo twig_escape_filter($this->env, (isset($context["pageTitle"]) ? $context["pageTitle"] : null), "html", null, true);
        echo "</title>
                <meta name=\"description\" content=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["metaData"]) ? $context["metaData"] : null), "metaDescription", array()), "html", null, true);
        echo "\">

                <!-- CSS FILES -->
                <link rel=\"stylesheet\" href=\"";
        // line 17
        echo twig_escape_filter($this->env, getCurrentDomain(), "html", null, true);
        echo "css/bootstrap.min.css\"/>
                <link rel=\"stylesheet\" href=\"";
        // line 18
        echo twig_escape_filter($this->env, getCurrentDomain(), "html", null, true);
        echo "assets/main.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 19
        echo twig_escape_filter($this->env, getCurrentDomain(), "html", null, true);
        echo "assets/main.css\" media=\"screen\" data-name=\"skins\">

                <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                <!--[if lt IE 9]>
                <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
                <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
                <![endif]-->

                <meta property=\"og:type\" content=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["metaData"]) ? $context["metaData"] : null), "metaType", array()), "html", null, true);
        echo "\"/>
                <meta property=\"og:title\" content=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["metaData"]) ? $context["metaData"] : null), "fbTitle", array()), "html", null, true);
        echo "\"/>
                <meta property=\"og:description\" content=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["metaData"]) ? $context["metaData"] : null), "metaDescription", array()), "html", null, true);
        echo "\"/>
                <meta property=\"og:keywords\" content=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["metaData"]) ? $context["metaData"] : null), "metaKeywords", array()), "html", null, true);
        echo "\"/>
                <meta property=\"og:image\" content=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["metaData"]) ? $context["metaData"] : null), "fbImg", array()), "html", null, true);
        echo "\"/>
                <meta property=\"og:url\" content=\"";
        // line 33
        echo twig_escape_filter($this->env, current_url(), "html", null, true);
        echo "\"/>
                <meta property=\"og:site_name\" content=\"Springconsult\"/>
                <meta property=\"fb:app_id\" content=\"124735281036290\"/>

                <link rel=\"icon\" href=\"";
        // line 37
        echo twig_escape_filter($this->env, getCurrentDomain(), "html", null, true);
        echo "favicon.ico\" type=\"image/x-icon\">
                <link rel=\"shortcut icon\" href=\"";
        // line 38
        echo twig_escape_filter($this->env, getCurrentDomain(), "html", null, true);
        echo "favicon.ico\" type=\"image/x-icon\">

                ";
        // line 40
        $this->loadTemplate("blocks/header_social_scripts.html.twig", "layout.html.twig", 40)->display($context);
        // line 41
        echo "            ";
    }

    // line 44
    public function block_header($context, array $blocks = array())
    {
        // line 45
        echo "            <header id=\"header\">
                <div id=\"top-bar\">
                    <div class=\"container\">
                        <div class=\"row\">
                            <div class=\"col-sm-8 top-info hidden-xs\">
                                <span><i class=\"fa fa-phone\"></i>Phone: (097) 916-24-56</span>
                                <span><i class=\"fa fa-envelope\"></i>Email: spring@springconsult.com.ua</span>
                            </div>
                            <div class=\"col-sm-4 top-info\">
                                <ul>
                                    <li><a href=\"http://www.facebook.com/pages/Spring-Consulting/224221514260502\" class=\"my-facebook\"><i class=\"fa fa-facebook\"></i></a></li>
                                    <li><a href=\"skype:helen.litkovskaya?call\" class=\"my-skype\"><i class=\"fa fa-skype\"></i></a></li>
                                    <li><a href=\"\" class=\"my-google\"><i class=\"fa fa-google-plus\"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id=\"logo-bar\">
                    <div class=\"container\">
                        <div class=\"row\">
                            <!-- Logo / Mobile Menu -->
                            <div  class=\"col-lg-3 col-sm-3 \">
                                <div id=\"logo\">
                                    <h1><a href=\"";
        // line 69
        echo twig_escape_filter($this->env, base_url(), "html", null, true);
        echo "\"><img alt=\"logo\" src=\"";
        echo twig_escape_filter($this->env, getCurrentDomain(), "html", null, true);
        echo "img/logo.png\"/></a></h1>
                                </div>
                            </div>
                            ";
        // line 72
        $this->loadTemplate("blocks/top_menu.html.twig", "layout.html.twig", 72)->display(array_merge($context, array("topLevelMenuList" => (isset($context["topLevelMenuList"]) ? $context["topLevelMenuList"] : null))));
        // line 73
        echo "                        </div>
                    </div>
                </div>
            </header>
            ";
    }

    // line 79
    public function block_content($context, array $blocks = array())
    {
    }

    // line 81
    public function block_gift($context, array $blocks = array())
    {
        // line 82
        echo "                <section class=\"page_head\">
                    <div class=\"container\">
                        <div class=\"row\">
                            <div class=\"col-lg-12 col-md-12 col-sm-12\">
                                <div class=\"page_title\">
                                    ";
        // line 88
        echo "                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <gift-container></gift-container>
            ";
    }

    // line 96
    public function block_footer($context, array $blocks = array())
    {
        // line 97
        echo "                ";
        $this->loadTemplate("blocks/footer.html.twig", "layout.html.twig", 97)->display($context);
        // line 98
        echo "                ";
        $this->loadTemplate("blocks/footer_scripts.html.twig", "layout.html.twig", 98)->display($context);
        // line 99
        echo "                ";
        $this->loadTemplate("blocks/header_angular_scripts.html.twig", "layout.html.twig", 99)->display($context);
        // line 100
        echo "            ";
    }

    public function getTemplateName()
    {
        return "layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  226 => 100,  223 => 99,  220 => 98,  217 => 97,  214 => 96,  204 => 88,  197 => 82,  194 => 81,  189 => 79,  181 => 73,  179 => 72,  171 => 69,  145 => 45,  142 => 44,  138 => 41,  136 => 40,  131 => 38,  127 => 37,  120 => 33,  116 => 32,  112 => 31,  108 => 30,  104 => 29,  100 => 28,  88 => 19,  84 => 18,  80 => 17,  74 => 14,  70 => 13,  65 => 10,  62 => 9,  57 => 101,  55 => 96,  52 => 95,  50 => 81,  47 => 80,  45 => 79,  42 => 78,  40 => 44,  36 => 42,  34 => 9,  24 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
    <!--[if IE 8 ]>
    <html class=\"ie ie8\" class=\"no-js\" lang=\"en\">
    <![endif]-->
    <!--[if (gte IE 9)|!(IE)]><!-->
    <html class=\"no-js\" lang=\"en\">
    <!--<![endif]-->
        <head>
            {% block head %}
                <meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
                <title>Spring Consulting - {{ pageTitle }}</title>
                <meta name=\"description\" content=\"{{ metaData.metaDescription }}\">

                <!-- CSS FILES -->
                <link rel=\"stylesheet\" href=\"{{ getCurrentDomain() }}css/bootstrap.min.css\"/>
                <link rel=\"stylesheet\" href=\"{{ getCurrentDomain() }}assets/main.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"{{ getCurrentDomain() }}assets/main.css\" media=\"screen\" data-name=\"skins\">

                <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                <!--[if lt IE 9]>
                <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
                <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
                <![endif]-->

                <meta property=\"og:type\" content=\"{{ metaData.metaType }}\"/>
                <meta property=\"og:title\" content=\"{{ metaData.fbTitle }}\"/>
                <meta property=\"og:description\" content=\"{{ metaData.metaDescription }}\"/>
                <meta property=\"og:keywords\" content=\"{{ metaData.metaKeywords }}\"/>
                <meta property=\"og:image\" content=\"{{ metaData.fbImg }}\"/>
                <meta property=\"og:url\" content=\"{{ current_url() }}\"/>
                <meta property=\"og:site_name\" content=\"Springconsult\"/>
                <meta property=\"fb:app_id\" content=\"124735281036290\"/>

                <link rel=\"icon\" href=\"{{ getCurrentDomain() }}favicon.ico\" type=\"image/x-icon\">
                <link rel=\"shortcut icon\" href=\"{{ getCurrentDomain() }}favicon.ico\" type=\"image/x-icon\">

                {% include 'blocks/header_social_scripts.html.twig' %}
            {% endblock %}
        </head>
        <body>
            {% block header %}
            <header id=\"header\">
                <div id=\"top-bar\">
                    <div class=\"container\">
                        <div class=\"row\">
                            <div class=\"col-sm-8 top-info hidden-xs\">
                                <span><i class=\"fa fa-phone\"></i>Phone: (097) 916-24-56</span>
                                <span><i class=\"fa fa-envelope\"></i>Email: spring@springconsult.com.ua</span>
                            </div>
                            <div class=\"col-sm-4 top-info\">
                                <ul>
                                    <li><a href=\"http://www.facebook.com/pages/Spring-Consulting/224221514260502\" class=\"my-facebook\"><i class=\"fa fa-facebook\"></i></a></li>
                                    <li><a href=\"skype:helen.litkovskaya?call\" class=\"my-skype\"><i class=\"fa fa-skype\"></i></a></li>
                                    <li><a href=\"\" class=\"my-google\"><i class=\"fa fa-google-plus\"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id=\"logo-bar\">
                    <div class=\"container\">
                        <div class=\"row\">
                            <!-- Logo / Mobile Menu -->
                            <div  class=\"col-lg-3 col-sm-3 \">
                                <div id=\"logo\">
                                    <h1><a href=\"{{ base_url() }}\"><img alt=\"logo\" src=\"{{ getCurrentDomain() }}img/logo.png\"/></a></h1>
                                </div>
                            </div>
                            {% include 'blocks/top_menu.html.twig' with {'topLevelMenuList': topLevelMenuList} %}
                        </div>
                    </div>
                </div>
            </header>
            {% endblock %}

            {% block content %}{% endblock %}

            {% block gift %}
                <section class=\"page_head\">
                    <div class=\"container\">
                        <div class=\"row\">
                            <div class=\"col-lg-12 col-md-12 col-sm-12\">
                                <div class=\"page_title\">
                                    {#<h2>Подарок</h2>#}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <gift-container></gift-container>
            {% endblock %}

            {% block footer %}
                {% include 'blocks/footer.html.twig' %}
                {% include 'blocks/footer_scripts.html.twig' %}
                {% include 'blocks/header_angular_scripts.html.twig' %}
            {% endblock %}
        </body>
</html>", "layout.html.twig", "/var/www/springconsult.loc/application/views/layout.html.twig");
    }
}
