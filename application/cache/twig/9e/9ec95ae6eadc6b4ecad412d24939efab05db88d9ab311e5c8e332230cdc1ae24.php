<?php

/* blocks/footer.html.twig */
class __TwigTemplate_4bee104e9b2932c4d75c6c1b52bfc824bc4c776d9830dbb8a438d3815fbffb0a extends Twig_Template
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
        echo "<footer class=\"footer\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-sm-6 col-md-4 col-lg-4\">
                <div class=\"widget_title\">
                    <h4><span>Контакты</span></h4>
                </div>
                <div class=\"widget_content\">
                    <ul class=\"contact-details-alt\">
                        <li>
                            <i class=\"fa fa-phone\"></i>
                            <p>
                                <strong>Phone:</strong>
                                (097) 916-24-56</p>
                        </li>
                        <li>
                            <i class=\"fa fa-envelope\"></i>
                            <p>
                                <strong>Email:</strong>
                                <a href=\"mail:spring@springconsult.com.ua\">spring@springconsult.com.ua</a>
                            </p>
                        </li>
                        <li>
                            <i class=\"fa fa-skype\"></i>
                            <p>
                                <strong>Skype:</strong>
                                <a href=\"skype:helen.litkovskaya?call\" class=\"my-skype\">helen.litkovskaya</a>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class=\"col-sm-6 col-md-4 col-lg-4\">
                <div class=\"widget_title\">
                    <h4><span>Блог</span></h4>
                </div>
                <div class=\"widget_content\">
                    <ul class=\"links\">
                        ";
        // line 39
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["lastArticleList"]) ? $context["lastArticleList"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
            // line 40
            echo "                            <li>
                                <a href=\"";
            // line 41
            echo twig_escape_filter($this->env, base_url(), "html", null, true);
            echo "article/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["article"], "id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["article"], "title", array()), "html", null, true);
            echo "</a>
                            </li>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['article'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "                    </ul>
                </div>
            </div>
            <div class=\"col-sm-6 col-md-4 col-lg-4\">
                <div class=\"widget_title\">
                    <h4><span>Продукты</span></h4>
                </div>
                <div class=\"widget_content\">
                    <div class=\"widget_content\">
                        <ul class=\"links\">
                            ";
        // line 54
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["lastSaleProductList"]) ? $context["lastSaleProductList"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
            // line 55
            echo "                                <li>
                                    <a href=\"";
            // line 56
            echo twig_escape_filter($this->env, base_url(), "html", null, true);
            echo "shop#product-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "title", array()), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["product"], "label", array()), "html", null, true);
            echo "</a>
                                </li>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 59
        echo "                        </ul>
                    </div>
                </div>
                <div class=\"widget_content\">
                    <div class=\"tweet_go\"></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<section class=\"footer_bottom\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-sm-6\">
                <p class=\"copyright\">&copy; Copyright 2017 Spring Consulting</p>
            </div>

            <div class=\"col-sm-6 \">
                <div class=\"footer_social\">
                    <ul class=\"footbot_social\">
                        <li><a class=\"fb\" href=\"http://www.facebook.com/pages/Spring-Consulting/224221514260502\" data-placement=\"top\" data-toggle=\"tooltip\" title=\"Facebook\"><i class=\"fa fa-facebook\"></i></a></li>
                        <li><a class=\"skype\" href=\"skype:helen.litkovskaya?call\" data-placement=\"top\" data-toggle=\"tooltip\" title=\"Skype\"><i class=\"fa fa-skype\"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>";
    }

    public function getTemplateName()
    {
        return "blocks/footer.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  113 => 59,  98 => 56,  95 => 55,  91 => 54,  79 => 44,  66 => 41,  63 => 40,  59 => 39,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<footer class=\"footer\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-sm-6 col-md-4 col-lg-4\">
                <div class=\"widget_title\">
                    <h4><span>Контакты</span></h4>
                </div>
                <div class=\"widget_content\">
                    <ul class=\"contact-details-alt\">
                        <li>
                            <i class=\"fa fa-phone\"></i>
                            <p>
                                <strong>Phone:</strong>
                                (097) 916-24-56</p>
                        </li>
                        <li>
                            <i class=\"fa fa-envelope\"></i>
                            <p>
                                <strong>Email:</strong>
                                <a href=\"mail:spring@springconsult.com.ua\">spring@springconsult.com.ua</a>
                            </p>
                        </li>
                        <li>
                            <i class=\"fa fa-skype\"></i>
                            <p>
                                <strong>Skype:</strong>
                                <a href=\"skype:helen.litkovskaya?call\" class=\"my-skype\">helen.litkovskaya</a>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class=\"col-sm-6 col-md-4 col-lg-4\">
                <div class=\"widget_title\">
                    <h4><span>Блог</span></h4>
                </div>
                <div class=\"widget_content\">
                    <ul class=\"links\">
                        {% for article in lastArticleList %}
                            <li>
                                <a href=\"{{ base_url() }}article/{{ article.id }}\">{{ article.title }}</a>
                            </li>
                        {% endfor %}
                    </ul>
                </div>
            </div>
            <div class=\"col-sm-6 col-md-4 col-lg-4\">
                <div class=\"widget_title\">
                    <h4><span>Продукты</span></h4>
                </div>
                <div class=\"widget_content\">
                    <div class=\"widget_content\">
                        <ul class=\"links\">
                            {% for product in lastSaleProductList %}
                                <li>
                                    <a href=\"{{ base_url() }}shop#product-{{ product.id }}\">{{ product.title }} {{ product.label }}</a>
                                </li>
                            {% endfor %}
                        </ul>
                    </div>
                </div>
                <div class=\"widget_content\">
                    <div class=\"tweet_go\"></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<section class=\"footer_bottom\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-sm-6\">
                <p class=\"copyright\">&copy; Copyright 2017 Spring Consulting</p>
            </div>

            <div class=\"col-sm-6 \">
                <div class=\"footer_social\">
                    <ul class=\"footbot_social\">
                        <li><a class=\"fb\" href=\"http://www.facebook.com/pages/Spring-Consulting/224221514260502\" data-placement=\"top\" data-toggle=\"tooltip\" title=\"Facebook\"><i class=\"fa fa-facebook\"></i></a></li>
                        <li><a class=\"skype\" href=\"skype:helen.litkovskaya?call\" data-placement=\"top\" data-toggle=\"tooltip\" title=\"Skype\"><i class=\"fa fa-skype\"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>", "blocks/footer.html.twig", "/var/www/springconsult.loc/application/views/blocks/footer.html.twig");
    }
}
