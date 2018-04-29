<?php

/* about/index.html.twig */
class __TwigTemplate_789a8f71ae934f6a7cfa6e5c4857b76f6cfbd91548abb874b26c172647a82a0f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "about/index.html.twig", 1);
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
                            <h2>";
        // line 17
        echo twig_escape_filter($this->env, (isset($context["pageTitle"]) ? $context["pageTitle"] : null), "html", null, true);
        echo "</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class=\"content service\">
            <div class=\"container\">
                <div class=\"row sub_content\">
                    <div class=\"who\">
                        <div class=\"col-lg-8 col-md-8 col-sm-8\">
                            ";
        // line 28
        echo $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "text", array());
        echo "
                        </div>

                        <div class=\"col-lg-4 col-md-4 col-sm-4\">
                            <div class=\"dividerHeading\">
                                <h4><span>Вопросы/Ответы</span></h4>
                            </div>
                            <ul class=\"recent_tab_list\">
                                ";
        // line 36
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["assignedArticleList"]) ? $context["assignedArticleList"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
            // line 37
            echo "                                    <li class=\"serviceBox_7\">
                                        <span class=\"service-icon fa fa-question\"></span>
                                        <a href=\"";
            // line 39
            echo twig_escape_filter($this->env, base_url(), "html", null, true);
            echo "article/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["article"], "id", array()), "html", null, true);
            echo "\">
                                            ";
            // line 40
            echo twig_escape_filter($this->env, $this->getAttribute($context["article"], "title", array()), "html", null, true);
            echo "
                                        </a>
                                    </li>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['article'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "                            </ul>
                        </div>
                    </div>
                </div>
                <div class=\"row sub_content\">
                    <div class=\"col-md-16 col-lg-16\">
                        <div class=\"dividerHeading\">
                            <h4><span>Мои результаты</span></h4>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">600</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>часов консультаций</h3>
                                <p>индивидуальных коуч-сессий</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">150</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>Составленных резюме</h3>
                                <p>успешно пройденных собеседований моими клиентами</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">45</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>авторских тренингов</h3>
                                <p>практикумов, мастер-классов и вебинаров</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">4</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>Книги</h3>
                                <p>по личной эфективности (2 печатных издания и 2 электронных)</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">200</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>Статей</h3>
                                <p>на тему понимания, развития себя и реализации своего потенциалана</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"row sub_content\">
                    <div class=\"col-lg-6 col-md-6 col-sm-6\">
                        <div class=\"dividerHeading\">
                            <h4><span>";
        // line 113
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["educationData"]) ? $context["educationData"] : null), "title", array()), "html", null, true);
        echo "</span></h4>
                        </div>
                        ";
        // line 115
        echo $this->getAttribute((isset($context["educationData"]) ? $context["educationData"] : null), "text", array());
        echo "
                    </div>

                    <div class=\"col-lg-6 col-md-6 col-sm-6\">
                        <div class=\"dividerHeading\">
                            <h4><span>Отзывы клиентов</span></h4>
                        </div>
                        <div id=\"testimonial-carousel\" class=\"testimonial carousel slide\">
                            <div class=\"carousel-inner\">
                                ";
        // line 124
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["reviewList"]) ? $context["reviewList"] : null));
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
            // line 125
            echo "                                    <div class=\"item testimonial-item ";
            if (($this->getAttribute($context["loop"], "index", array()) == 1)) {
                echo "active";
            }
            echo "\">
                                        <div class=\"icon\"><i class=\"fa fa-quote-right\"></i></div>
                                        <blockquote>
                                            <p>
                                                ";
            // line 129
            echo twig_slice($this->env, $this->getAttribute($context["review"], "text", array()), 0, 550);
            echo "
                                                <span class=\"show-more\" data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" data-content=\"";
            // line 130
            echo twig_escape_filter($this->env, $this->getAttribute($context["review"], "text", array()), "html", null, true);
            echo "\"> ...<i class=\"fa fa-search-plus\"></i></span>
                                            </p>
                                        </blockquote>
                                        <div class=\"icon-tr\"></div>
                                        <div class=\"testimonial-review\">
                                            <img src=\"";
            // line 135
            echo twig_escape_filter($this->env, getCurrentDomain(), "html", null, true);
            echo "img/review/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["review"], "image", array()), "html", null, true);
            echo "\" alt=\"testimoni\">
                                            <p>";
            // line 136
            echo twig_escape_filter($this->env, $this->getAttribute($context["review"], "author", array()), "html", null, true);
            echo "</p>
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
        // line 140
        echo "                            </div>
                            <div class=\"testimonial-buttons\">
                                <a href=\"#testimonial-carousel\" data-slide=\"prev\"><i class=\"fa fa-chevron-left\"></i></a>&#32;
                                <a href=\"#testimonial-carousel\" data-slide=\"next\"><i class=\"fa fa-chevron-right\"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

";
    }

    // line 154
    public function block_gift($context, array $blocks = array())
    {
        // line 155
        echo "    ";
        $this->displayParentBlock("gift", $context, $blocks);
        echo "
";
    }

    // line 158
    public function block_footer($context, array $blocks = array())
    {
        // line 159
        echo "    ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
    <script type=\"text/javascript\">
        \$('.shorten-education').shorten({
            showChars: 650,
            moreText: '<i class=\"fa fa-angle-down\"></i>',
            lessText: '<i class=\"fa fa-angle-up\"></i>'
        });
    </script>
";
    }

    public function getTemplateName()
    {
        return "about/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  292 => 159,  289 => 158,  282 => 155,  279 => 154,  263 => 140,  245 => 136,  239 => 135,  231 => 130,  227 => 129,  217 => 125,  200 => 124,  188 => 115,  183 => 113,  112 => 44,  102 => 40,  96 => 39,  92 => 37,  88 => 36,  77 => 28,  63 => 17,  55 => 11,  52 => 10,  45 => 8,  42 => 7,  35 => 4,  32 => 3,  11 => 1,);
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
                            <h2>{{ pageTitle }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class=\"content service\">
            <div class=\"container\">
                <div class=\"row sub_content\">
                    <div class=\"who\">
                        <div class=\"col-lg-8 col-md-8 col-sm-8\">
                            {{ data.text|raw }}
                        </div>

                        <div class=\"col-lg-4 col-md-4 col-sm-4\">
                            <div class=\"dividerHeading\">
                                <h4><span>Вопросы/Ответы</span></h4>
                            </div>
                            <ul class=\"recent_tab_list\">
                                {% for article in assignedArticleList %}
                                    <li class=\"serviceBox_7\">
                                        <span class=\"service-icon fa fa-question\"></span>
                                        <a href=\"{{ base_url() }}article/{{ article.id }}\">
                                            {{ article.title }}
                                        </a>
                                    </li>
                                {% endfor %}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class=\"row sub_content\">
                    <div class=\"col-md-16 col-lg-16\">
                        <div class=\"dividerHeading\">
                            <h4><span>Мои результаты</span></h4>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">600</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>часов консультаций</h3>
                                <p>индивидуальных коуч-сессий</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">150</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>Составленных резюме</h3>
                                <p>успешно пройденных собеседований моими клиентами</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">45</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>авторских тренингов</h3>
                                <p>практикумов, мастер-классов и вебинаров</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">4</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>Книги</h3>
                                <p>по личной эфективности (2 печатных издания и 2 электронных)</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-sm-2\">
                        <div class=\"serviceBox_4 my-result\">
                            <div class=\"service-icon\">
                                <i class=\"fa\">200</i>
                            </div>
                            <div class=\"service-content\">
                                <h3>Статей</h3>
                                <p>на тему понимания, развития себя и реализации своего потенциалана</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"row sub_content\">
                    <div class=\"col-lg-6 col-md-6 col-sm-6\">
                        <div class=\"dividerHeading\">
                            <h4><span>{{ educationData.title }}</span></h4>
                        </div>
                        {{ educationData.text|raw }}
                    </div>

                    <div class=\"col-lg-6 col-md-6 col-sm-6\">
                        <div class=\"dividerHeading\">
                            <h4><span>Отзывы клиентов</span></h4>
                        </div>
                        <div id=\"testimonial-carousel\" class=\"testimonial carousel slide\">
                            <div class=\"carousel-inner\">
                                {% for review in reviewList %}
                                    <div class=\"item testimonial-item {% if loop.index == 1 %}active{% endif %}\">
                                        <div class=\"icon\"><i class=\"fa fa-quote-right\"></i></div>
                                        <blockquote>
                                            <p>
                                                {{ review.text[:550]|raw }}
                                                <span class=\"show-more\" data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" data-content=\"{{ review.text }}\"> ...<i class=\"fa fa-search-plus\"></i></span>
                                            </p>
                                        </blockquote>
                                        <div class=\"icon-tr\"></div>
                                        <div class=\"testimonial-review\">
                                            <img src=\"{{ getCurrentDomain() }}img/review/{{ review.image }}\" alt=\"testimoni\">
                                            <p>{{ review.author }}</p>
                                        </div>
                                    </div>
                                {% endfor %}
                            </div>
                            <div class=\"testimonial-buttons\">
                                <a href=\"#testimonial-carousel\" data-slide=\"prev\"><i class=\"fa fa-chevron-left\"></i></a>&#32;
                                <a href=\"#testimonial-carousel\" data-slide=\"next\"><i class=\"fa fa-chevron-right\"></i></a>
                            </div>
                        </div>
                    </div>
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
    <script type=\"text/javascript\">
        \$('.shorten-education').shorten({
            showChars: 650,
            moreText: '<i class=\"fa fa-angle-down\"></i>',
            lessText: '<i class=\"fa fa-angle-up\"></i>'
        });
    </script>
{% endblock %}", "about/index.html.twig", "/var/www/springconsult.loc/application/views/about/index.html.twig");
    }
}
