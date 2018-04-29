<?php

/* blocks/header_angular_scripts.html.twig */
class __TwigTemplate_0215d6263c03f9ae048d25e2473f4180264c736e3536186d526c69029eac77a8 extends Twig_Template
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
        // line 3
        echo "
";
        // line 5
        echo "    ";
        // line 6
        echo "        ";
        // line 7
        echo "            ";
        // line 8
        echo "        ";
        // line 9
        echo "    ";
    }

    public function getTemplateName()
    {
        return "blocks/header_angular_scripts.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  30 => 9,  28 => 8,  26 => 7,  24 => 6,  22 => 5,  19 => 3,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#<script src=\"{{ getCurrentDomain() }}app-angular/node_modules/systemjs/dist/system.js\"></script>#}
{#<script src=\"{{ getCurrentDomain() }}app-angular/systemjs.config.extras.js\"></script>#}

{#<script>#}
    {#System.import('app').catch(#}
        {#function (err) {#}
            {#console.error(err);#}
        {#}#}
    {#);#}
{#</script>#}", "blocks/header_angular_scripts.html.twig", "/var/www/springconsult.loc/application/views/blocks/header_angular_scripts.html.twig");
    }
}
