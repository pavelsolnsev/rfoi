{% extends 'default.php' %}
{% set PAGE_TITLE = 'РФОИ — Рейтинг игроков | Любительский футбол Раменское' %}
{% set PAGE_DESC = 'Общий рейтинг игроков РФОИ — голы, ассисты, победы, MVP за все сезоны. Любительский футбол в Раменском, Московская область.' %}

{% block schema %}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Главная", "item": "https://football.pavelsolntsev.ru/"}
  ]
}
</script>
{% endblock %}