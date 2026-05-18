{% extends 'default.php' %}
{% set PAGE_CLASS = 'page-tournament' %}
{% set PAGE_TITLE = 'Турнирная таблица РФОИ — команды и результаты, Раменское' %}
{% set PAGE_DESC = 'Турнирная таблица команд РФОИ: победы, ничьи, поражения, трофеи. Любительский футбол в Раменском, Московская область.' %}

{% block blocks %}
{% include 'tournament/block-tournament.php' %}
{% endblock %}

{% block schema %}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Главная", "item": "https://football.pavelsolntsev.ru/"},
    {"@type": "ListItem", "position": 2, "name": "Турнир", "item": "https://football.pavelsolntsev.ru/tournament/"}
  ]
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SportsEvent",
  "name": "РФОИ — Турнир по любительскому футболу в Раменском",
  "description": "Регулярные турниры по любительскому футболу в Раменском. Участвуют команды разного уровня.",
  "sport": "Футбол",
  "organizer": {
    "@type": "SportsOrganization",
    "name": "РФОИ — Раменское Футбол Открытые Игры",
    "url": "https://football.pavelsolntsev.ru"
  },
  "location": {
    "@type": "Place",
    "name": "Раменское",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Раменское",
      "addressRegion": "Московская область",
      "addressCountry": "RU"
    }
  },
  "url": "https://football.pavelsolntsev.ru/tournament/"
}
</script>
{% endblock %}