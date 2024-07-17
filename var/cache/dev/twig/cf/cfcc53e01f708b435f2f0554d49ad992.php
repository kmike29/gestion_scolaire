<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* tranche_horaire/show.html.twig */
class __TwigTemplate_36deff804cf8640e69ea6dd9c80d49f4 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "tranche_horaire/show.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "tranche_horaire/show.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "tranche_horaire/show.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "TrancheHoraire";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        return; yield '';
    }

    // line 5
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        yield "    <h1>TrancheHoraire</h1>

    <table class=\"table\">
        <tbody>
            <tr>
                <th>Id</th>
                <td>";
        // line 12
        yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tranche_horaire"]) || array_key_exists("tranche_horaire", $context) ? $context["tranche_horaire"] : (function () { throw new RuntimeError('Variable "tranche_horaire" does not exist.', 12, $this->source); })()), "id", [], "any", false, false, false, 12), "html", null, true);
        yield "</td>
            </tr>
            <tr>
                <th>Jour</th>
                <td>";
        // line 16
        ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["tranche_horaire"]) || array_key_exists("tranche_horaire", $context) ? $context["tranche_horaire"] : (function () { throw new RuntimeError('Variable "tranche_horaire" does not exist.', 16, $this->source); })()), "jour", [], "any", false, false, false, 16)) ? (yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::dateFormatFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tranche_horaire"]) || array_key_exists("tranche_horaire", $context) ? $context["tranche_horaire"] : (function () { throw new RuntimeError('Variable "tranche_horaire" does not exist.', 16, $this->source); })()), "jour", [], "any", false, false, false, 16), "Y-m-d"), "html", null, true)) : (yield ""));
        yield "</td>
            </tr>
            <tr>
                <th>Debut</th>
                <td>";
        // line 20
        ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["tranche_horaire"]) || array_key_exists("tranche_horaire", $context) ? $context["tranche_horaire"] : (function () { throw new RuntimeError('Variable "tranche_horaire" does not exist.', 20, $this->source); })()), "debut", [], "any", false, false, false, 20)) ? (yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::dateFormatFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tranche_horaire"]) || array_key_exists("tranche_horaire", $context) ? $context["tranche_horaire"] : (function () { throw new RuntimeError('Variable "tranche_horaire" does not exist.', 20, $this->source); })()), "debut", [], "any", false, false, false, 20), "H:i:s"), "html", null, true)) : (yield ""));
        yield "</td>
            </tr>
            <tr>
                <th>Fin</th>
                <td>";
        // line 24
        ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["tranche_horaire"]) || array_key_exists("tranche_horaire", $context) ? $context["tranche_horaire"] : (function () { throw new RuntimeError('Variable "tranche_horaire" does not exist.', 24, $this->source); })()), "fin", [], "any", false, false, false, 24)) ? (yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::dateFormatFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tranche_horaire"]) || array_key_exists("tranche_horaire", $context) ? $context["tranche_horaire"] : (function () { throw new RuntimeError('Variable "tranche_horaire" does not exist.', 24, $this->source); })()), "fin", [], "any", false, false, false, 24), "H:i:s"), "html", null, true)) : (yield ""));
        yield "</td>
            </tr>
        </tbody>
    </table>

    <a href=\"";
        // line 29
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_tranche_horaire_index");
        yield "\">back to list</a>

    <a href=\"";
        // line 31
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_tranche_horaire_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["tranche_horaire"]) || array_key_exists("tranche_horaire", $context) ? $context["tranche_horaire"] : (function () { throw new RuntimeError('Variable "tranche_horaire" does not exist.', 31, $this->source); })()), "id", [], "any", false, false, false, 31)]), "html", null, true);
        yield "\">edit</a>

    ";
        // line 33
        yield Twig\Extension\CoreExtension::include($this->env, $context, "tranche_horaire/_delete_form.html.twig");
        yield "
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "tranche_horaire/show.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  137 => 33,  132 => 31,  127 => 29,  119 => 24,  112 => 20,  105 => 16,  98 => 12,  90 => 6,  80 => 5,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}TrancheHoraire{% endblock %}

{% block body %}
    <h1>TrancheHoraire</h1>

    <table class=\"table\">
        <tbody>
            <tr>
                <th>Id</th>
                <td>{{ tranche_horaire.id }}</td>
            </tr>
            <tr>
                <th>Jour</th>
                <td>{{ tranche_horaire.jour ? tranche_horaire.jour|date('Y-m-d') : '' }}</td>
            </tr>
            <tr>
                <th>Debut</th>
                <td>{{ tranche_horaire.debut ? tranche_horaire.debut|date('H:i:s') : '' }}</td>
            </tr>
            <tr>
                <th>Fin</th>
                <td>{{ tranche_horaire.fin ? tranche_horaire.fin|date('H:i:s') : '' }}</td>
            </tr>
        </tbody>
    </table>

    <a href=\"{{ path('app_tranche_horaire_index') }}\">back to list</a>

    <a href=\"{{ path('app_tranche_horaire_edit', {'id': tranche_horaire.id}) }}\">edit</a>

    {{ include('tranche_horaire/_delete_form.html.twig') }}
{% endblock %}
", "tranche_horaire/show.html.twig", "C:\\Users\\Enam\\projets\\gestion_scolaire\\templates\\tranche_horaire\\show.html.twig");
    }
}
