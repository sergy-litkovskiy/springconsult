<?php

/* blocks/header_social_scripts.html.twig */
class __TwigTemplate_60c30959aef362705700ece0b49dfc5a3be95a202416df1bcc2c8cfa633b1529 extends Twig_Template
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
        echo "<script>
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-26859672-1']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

    // Load the SDK Asynchronously
    (function (d) {
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = \"//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=124735281036290\";
        ref.parentNode.insertBefore(js, ref);
    }(document));

    !function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = \"//platform.twitter.com/widgets.js\";
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, \"script\", \"twitter-wjs\");
</script>
";
    }

    public function getTemplateName()
    {
        return "blocks/header_social_scripts.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<script>
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-26859672-1']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

    // Load the SDK Asynchronously
    (function (d) {
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = \"//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=124735281036290\";
        ref.parentNode.insertBefore(js, ref);
    }(document));

    !function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = \"//platform.twitter.com/widgets.js\";
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, \"script\", \"twitter-wjs\");
</script>
", "blocks/header_social_scripts.html.twig", "/var/www/springconsult.loc/application/views/blocks/header_social_scripts.html.twig");
    }
}
