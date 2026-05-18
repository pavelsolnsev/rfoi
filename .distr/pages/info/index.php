{% extends 'default.php' %}
{% set PAGE_CLASS = 'page-static' %}
{% set PAGE_TITLE = 'Информация о РФОИ — правила, рейтинг, турниры | Раменское' %}
{% set PAGE_DESC = 'Правила рейтинговой системы РФОИ, информация о турнирах и открытых играх по любительскому футболу в Раменском.' %}

{% block blocks %}
{% include 'info/block.php' %}
{% endblock %}

{% block schema %}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Главная", "item": "https://football.pavelsolntsev.ru/"},
    {"@type": "ListItem", "position": 2, "name": "Информация", "item": "https://football.pavelsolntsev.ru/info/"}
  ]
}
</script>
{% endblock %}

