<?php

/* blocks/top_menu.html.twig */
class __TwigTemplate_2e5d981c218edca5eb5f30bc9385a70e221365725cce36be8dcb158d6c680724 extends Twig_Template
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
        echo "<div class=\"col-lg-9 col-sm-9\">
    <div class=\"navbar navbar-default navbar-static-top\" role=\"navigation\">
        <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
        </div>
        <div class=\"navbar-collapse collapse\">
            <ul class=\"nav navbar-nav\">
                ";
        // line 13
        $context["currentItemName"] = ((array_key_exists("currentItemName", $context)) ? ((isset($context["currentItemName"]) ? $context["currentItemName"] : null)) : ("service"));
        // line 14
        echo "
                <li ";
        // line 15
        if (((isset($context["currentItemName"]) ? $context["currentItemName"] : null) == "service")) {
            echo "class=\"active\"";
        }
        echo ">
                    <a href=\"";
        // line 16
        echo twig_escape_filter($this->env, base_url(), "html", null, true);
        echo "\">Услуги</a>
                </li>
                <li ";
        // line 18
        if (((isset($context["currentItemName"]) ? $context["currentItemName"] : null) == "about")) {
            echo "class=\"active\"";
        }
        echo ">
                    <a href=\"";
        // line 19
        echo twig_escape_filter($this->env, base_url(), "html", null, true);
        echo "about\">Об авторе проекта</a>
                </li>
                <li ";
        // line 21
        if (((isset($context["currentItemName"]) ? $context["currentItemName"] : null) == "shop")) {
            echo "class=\"active\"";
        }
        echo ">
                    <a href=\"";
        // line 22
        echo twig_escape_filter($this->env, base_url(), "html", null, true);
        echo "shop\">Магазин</a>
                </li>
                <li ";
        // line 24
        if (((isset($context["currentItemName"]) ? $context["currentItemName"] : null) == "blog")) {
            echo "class=\"active\"";
        }
        echo ">
                    <a href=\"";
        // line 25
        echo twig_escape_filter($this->env, base_url(), "html", null, true);
        echo "blog\">Блог</a>
                </li>
                <li ";
        // line 27
        if (((isset($context["currentItemName"]) ? $context["currentItemName"] : null) == "review")) {
            echo "class=\"active\"";
        }
        echo ">
                    <a href=\"";
        // line 28
        echo twig_escape_filter($this->env, base_url(), "html", null, true);
        echo "review\">Отзывы</a>
                </li>
            </ul>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "blocks/top_menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 28,  82 => 27,  77 => 25,  71 => 24,  66 => 22,  60 => 21,  55 => 19,  49 => 18,  44 => 16,  38 => 15,  35 => 14,  33 => 13,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"col-lg-9 col-sm-9\">
    <div class=\"navbar navbar-default navbar-static-top\" role=\"navigation\">
        <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
        </div>
        <div class=\"navbar-collapse collapse\">
            <ul class=\"nav navbar-nav\">
                {% set currentItemName = currentItemName is defined ? currentItemName : 'service' %}

                <li {% if currentItemName == 'service' %}class=\"active\"{% endif %}>
                    <a href=\"{{ base_url() }}\">Услуги</a>
                </li>
                <li {% if currentItemName == 'about' %}class=\"active\"{% endif %}>
                    <a href=\"{{ base_url() }}about\">Об авторе проекта</a>
                </li>
                <li {% if currentItemName == 'shop' %}class=\"active\"{% endif %}>
                    <a href=\"{{ base_url() }}shop\">Магазин</a>
                </li>
                <li {% if currentItemName == 'blog' %}class=\"active\"{% endif %}>
                    <a href=\"{{ base_url() }}blog\">Блог</a>
                </li>
                <li {% if currentItemName == 'review' %}class=\"active\"{% endif %}>
                    <a href=\"{{ base_url() }}review\">Отзывы</a>
                </li>
            </ul>
        </div>
    </div>
</div>", "blocks/top_menu.html.twig", "/var/www/springconsult.loc/application/views/blocks/top_menu.html.twig");
    }
}
