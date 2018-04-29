<?php

/* service/index.html.twig */
class __TwigTemplate_2d2836e70b5b28de211a320fa0524cb1a63fb11cb52c4d8fd52e704d8fc8f23d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "service/index.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
            'gift' => array($this, 'block_gift'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "
";
    }

    // line 7
    public function block_header($context, array $blocks = array())
    {
        // line 8
        echo "    ";
        $this->displayParentBlock("header", $context, $blocks);
        echo "
";
    }

    // line 10
    public function block_content($context, array $blocks = array())
    {
        // line 11
        echo "    <section class=\"wrapper\">
        <section class=\"page_head\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-lg-12 col-md-12 col-sm-12\">
                        <div class=\"page_title\">
                            <h2>Услуги</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class=\"content service\">
            <div class=\"container\">
                <div class=\"row sub_content\">
                    ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["serviceToReviewsMap"]) ? $context["serviceToReviewsMap"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["serviceToReviewsItem"]) {
            // line 27
            echo "                        <div class=\"col-md-3 col-sm-6\">
                            <div class=\"serviceBox_2 ";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "color_class", array()), "html", null, true);
            echo "\">
                                <div class=\"service-icon\">
                                    <a href=\"";
            // line 30
            echo twig_escape_filter($this->env, base_url(), "html", null, true);
            echo "service/";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "id", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "slug", array()), "html", null, true);
            echo "\">
                                        <i class=\"fa ";
            // line 31
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "icon_class", array()), "html", null, true);
            echo "\"></i>
                                    </a>
                                </div>
                                <div class=\"service-content\">
                                    <h3>
                                        <a href=\"";
            // line 36
            echo twig_escape_filter($this->env, base_url(), "html", null, true);
            echo "service/";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "id", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "slug", array()), "html", null, true);
            echo "\">
                                            ";
            // line 37
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "title", array()), "html", null, true);
            echo "
                                        </a>
                                    </h3>
                                    <div>
                                        ";
            // line 41
            echo twig_slice($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "description", array()), 0, 150);
            echo "
                                        <span class=\"show-more\" data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" data-content=\"";
            // line 42
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "description", array()), "html", null, true);
            echo "\"> ...<i class=\"fa fa-search-plus\"></i></span>
                                    </div>
                                    <div class=\"read\">
                                        <a href=\"";
            // line 45
            echo twig_escape_filter($this->env, base_url(), "html", null, true);
            echo "service/";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "id", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "slug", array()), "html", null, true);
            echo "\">Далее</a>
                                    </div>
                                </div>
                            </div>
                            ";
            // line 49
            if (twig_length_filter($this->env, $this->getAttribute($context["serviceToReviewsItem"], "reviewList", array()))) {
                // line 50
                echo "                                <div class=\"review-block\">
                                    <div class=\"dividerHeading\">
                                        <h4><span>Отзывы</span></h4>
                                    </div>
                                    <div class=\"testimonial carousel slide\" id=\"testimonial-carousel-";
                // line 54
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "id", array()), "html", null, true);
                echo "\" data-ride=\"carousel\">
                                        <div class=\"carousel-inner\">
                                            ";
                // line 56
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["serviceToReviewsItem"], "reviewList", array()));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["review"]) {
                    // line 57
                    echo "                                                <div class=\"item ";
                    if (($this->getAttribute($context["loop"], "index", array()) == 1)) {
                        echo "active";
                    }
                    echo "\">
                                                    <div class=\"testimonial-item\">
                                                        <div class=\"icon\"><i class=\"fa fa-quote-right\"></i></div>
                                                        <blockquote>
                                                            <p>
                                                                ";
                    // line 62
                    echo twig_slice($this->env, $this->getAttribute($context["review"], "text", array()), 0, 150);
                    echo "
                                                                <span class=\"show-more\" data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" data-content=\"";
                    // line 63
                    echo twig_escape_filter($this->env, $this->getAttribute($context["review"], "text", array()), "html", null, true);
                    echo "\"> ...<i class=\"fa fa-search-plus\"></i></span>
                                                            </p>
                                                        </blockquote>
                                                        <div class=\"icon-tr\"></div>
                                                        <div class=\"testimonial-review\">
                                                            <img alt=\"testimoni\" src=\"";
                    // line 68
                    echo twig_escape_filter($this->env, getCurrentDomain(), "html", null, true);
                    echo "img/review/";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["review"], "image", array()), "html", null, true);
                    echo "\"/>
                                                            <p>";
                    // line 69
                    echo twig_escape_filter($this->env, $this->getAttribute($context["review"], "author", array()), "html", null, true);
                    echo "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['review'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 74
                echo "                                        </div>
                                        <div class=\"testimonial-buttons\">
                                            <a data-slide=\"prev\" href=\"#testimonial-carousel-";
                // line 76
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "id", array()), "html", null, true);
                echo "\">
                                                <i class=\"fa fa-chevron-left\"></i>
                                            </a>&#32;
                                            <a data-slide=\"next\" href=\"#testimonial-carousel-";
                // line 79
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["serviceToReviewsItem"], "data", array()), "id", array()), "html", null, true);
                echo "\">
                                                <i class=\"fa fa-chevron-right\"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            ";
            }
            // line 86
            echo "                        </div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['serviceToReviewsItem'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 88
        echo "                </div>
            </div>
        </section>
    </section>
";
    }

    // line 94
    public function block_gift($context, array $blocks = array())
    {
        // line 95
        echo "    ";
        $this->displayParentBlock("gift", $context, $blocks);
        echo "
";
    }

    // line 98
    public function block_footer($context, array $blocks = array())
    {
        // line 99
        echo "    ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
";
    }

    public function getTemplateName()
    {
        return "service/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  262 => 99,  259 => 98,  252 => 95,  249 => 94,  241 => 88,  234 => 86,  224 => 79,  218 => 76,  214 => 74,  195 => 69,  189 => 68,  181 => 63,  177 => 62,  166 => 57,  149 => 56,  144 => 54,  138 => 50,  136 => 49,  125 => 45,  119 => 42,  115 => 41,  108 => 37,  100 => 36,  92 => 31,  84 => 30,  79 => 28,  76 => 27,  72 => 26,  55 => 11,  52 => 10,  45 => 8,  42 => 7,  35 => 4,  32 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout.html.twig\" %}

{% block head %}
    {{ parent() }}
{% endblock %}

{% block header %}
    {{ parent() }}
{% endblock %}
{% block content %}
    <section class=\"wrapper\">
        <section class=\"page_head\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-lg-12 col-md-12 col-sm-12\">
                        <div class=\"page_title\">
                            <h2>Услуги</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class=\"content service\">
            <div class=\"container\">
                <div class=\"row sub_content\">
                    {% for serviceToReviewsItem in serviceToReviewsMap %}
                        <div class=\"col-md-3 col-sm-6\">
                            <div class=\"serviceBox_2 {{ serviceToReviewsItem.data.color_class }}\">
                                <div class=\"service-icon\">
                                    <a href=\"{{ base_url() }}service/{{ serviceToReviewsItem.data.id }}/{{ serviceToReviewsItem.data.slug }}\">
                                        <i class=\"fa {{ serviceToReviewsItem.data.icon_class }}\"></i>
                                    </a>
                                </div>
                                <div class=\"service-content\">
                                    <h3>
                                        <a href=\"{{ base_url() }}service/{{ serviceToReviewsItem.data.id }}/{{ serviceToReviewsItem.data.slug }}\">
                                            {{ serviceToReviewsItem.data.title }}
                                        </a>
                                    </h3>
                                    <div>
                                        {{ serviceToReviewsItem.data.description[:150]|raw }}
                                        <span class=\"show-more\" data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" data-content=\"{{ serviceToReviewsItem.data.description }}\"> ...<i class=\"fa fa-search-plus\"></i></span>
                                    </div>
                                    <div class=\"read\">
                                        <a href=\"{{ base_url() }}service/{{ serviceToReviewsItem.data.id }}/{{ serviceToReviewsItem.data.slug }}\">Далее</a>
                                    </div>
                                </div>
                            </div>
                            {% if serviceToReviewsItem.reviewList|length %}
                                <div class=\"review-block\">
                                    <div class=\"dividerHeading\">
                                        <h4><span>Отзывы</span></h4>
                                    </div>
                                    <div class=\"testimonial carousel slide\" id=\"testimonial-carousel-{{ serviceToReviewsItem.data.id }}\" data-ride=\"carousel\">
                                        <div class=\"carousel-inner\">
                                            {% for review in serviceToReviewsItem.reviewList %}
                                                <div class=\"item {% if loop.index == 1 %}active{% endif %}\">
                                                    <div class=\"testimonial-item\">
                                                        <div class=\"icon\"><i class=\"fa fa-quote-right\"></i></div>
                                                        <blockquote>
                                                            <p>
                                                                {{ review.text[:150]|raw }}
                                                                <span class=\"show-more\" data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" data-content=\"{{ review.text }}\"> ...<i class=\"fa fa-search-plus\"></i></span>
                                                            </p>
                                                        </blockquote>
                                                        <div class=\"icon-tr\"></div>
                                                        <div class=\"testimonial-review\">
                                                            <img alt=\"testimoni\" src=\"{{ getCurrentDomain() }}img/review/{{ review.image }}\"/>
                                                            <p>{{ review.author }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            {% endfor %}
                                        </div>
                                        <div class=\"testimonial-buttons\">
                                            <a data-slide=\"prev\" href=\"#testimonial-carousel-{{ serviceToReviewsItem.data.id }}\">
                                                <i class=\"fa fa-chevron-left\"></i>
                                            </a>&#32;
                                            <a data-slide=\"next\" href=\"#testimonial-carousel-{{ serviceToReviewsItem.data.id }}\">
                                                <i class=\"fa fa-chevron-right\"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            {% endif %}
                        </div>
                    {% endfor %}
                </div>
            </div>
        </section>
    </section>
{% endblock %}

{% block gift %}
    {{ parent() }}
{% endblock %}

{% block footer %}
    {{ parent() }}
{% endblock %}", "service/index.html.twig", "/var/www/springconsult.loc/application/views/service/index.html.twig");
    }
}
