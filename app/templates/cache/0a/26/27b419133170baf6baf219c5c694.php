<?php

/* index/index.html */
class __TwigTemplate_0a2627b419133170baf6baf219c5c694 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout.html");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'navigation' => array($this, 'block_navigation'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "HOME";
    }

    // line 4
    public function block_navigation($context, array $blocks = array())
    {
        // line 5
        echo "<li class=\"active\"><a href=\"/\">HOME</a></li>
";
    }

    // line 8
    public function block_content($context, array $blocks = array())
    {
        // line 9
        echo "    <div class=\"page-header\">
        <h2>Home</h2>
    </div>

    <h2>Latest Blog Posts</h2>
    ";
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["post_list"]) ? $context["post_list"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 15
            echo "        <h3><a href=\"/post/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "id"));
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "title"));
            echo "</a></h3>
        <div>
            <span>";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "post_date"));
            echo "</span>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "index/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 17,  58 => 15,  54 => 14,  47 => 9,  44 => 8,  39 => 5,  36 => 4,  30 => 3,);
    }
}
