<!DOCTYPE html>
<html lang="ru">
<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'] . '/';
$BASE_HREF = '//' . $_SERVER['HTTP_HOST'] . (!empty($_SERVER['DOCUMENT_URI']) ? str_replace(substr(str_replace('index.php', '', $_SERVER['DOCUMENT_URI']), 1), '', $_SERVER['REQUEST_URI']) : '');
$URL = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$query_string = http_build_query($_GET);
function isMobile()
{
    return preg_match('/(android|iphone|ipad|mobile)/i', $_SERVER['HTTP_USER_AGENT']);
}
$cssVersion = filemtime($_SERVER['DOCUMENT_ROOT'] . '/css/style.css');
$jsVersion = filemtime($_SERVER['DOCUMENT_ROOT'] . '/js/script.js');
?>

<head>
    <base href="<?= $BASE_HREF . ($query_string ? '?' . $query_string : '') ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>РФОИ — Раменское Футбол | Открытые Игры</title>
    <meta name="description" content="Рейтинг игроков любительского футбола в Раменском — голы, ассисты, победы, MVP. Составы команд и статистика каждого игрока РФОИ. Раменское, Московская область.">
    <meta name="keywords" content="футбол Раменское, любительский футбол Раменское, РФОИ, Раменское Футбол Открытые Игры, турнир по футболу Раменское, футбольные команды Раменское, рейтинг игроков футбол">
    <meta name="robots" content="index, follow">
    <meta name="author" content="РФОИ — Раменское Футбол Открытые Игры">
    <link rel="canonical" href="https://football.pavelsolntsev.ru<?= strtok($_SERVER['REQUEST_URI'], '?') ?>">
    <meta property="og:title" content="РФОИ — Раменское Футбол | Открытые Игры">
    <meta property="og:description" content="Любительский футбол в Раменском — рейтинги игроков, составы команд, результаты турниров. Раменское Футбол Открытые Игры.">
    <meta property="og:url" content="https://football.pavelsolntsev.ru<?= strtok($_SERVER['REQUEST_URI'], '?') ?>">
    <meta property="og:image" content="https://football.pavelsolntsev.ru/img/main/logo.svg">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:site_name" content="РФОИ — Раменское Футбол Открытые Игры">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="РФОИ — Раменское Футбол | Открытые Игры">
    <meta name="twitter:description" content="Любительский футбол в Раменском — рейтинги, команды, турниры.">
    <link rel="image_src" href="https://football.pavelsolntsev.ru/img/main/logo.svg">

    <!-- Preconnect: браузер заранее открывает соединение с CDN, не тратя время при загрузке -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    <!-- Основной CSS сайта — критичный, грузим первым синхронно -->
    <link rel="icon" href="/favicon.svg" type="image/svg+xml" sizes="any">
    <link rel="stylesheet" href="css/style.css?v=<?= $cssVersion ?>">

    <!-- Bootstrap: preload + неблокирующая загрузка через onload -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"></noscript>

    <!-- FontAwesome: иконки — некритичны, грузим асинхронно -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css"></noscript>

    <!-- Swiper: только на странице турнира, но грузим везде асинхронно -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"></noscript>
</head>

<body class="{{ PAGE_CLASS }}">

    <div class="wrapper">
        {% block blocks %}
        {% include 'main/block.php' %}
        {% endblock %}

        {% include 'footer/block.php' %}
    </div>

    {% block popups %}
	{% include 'popups/block.php' %}
	{% endblock %}

<?php
$currentPath = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$isInfoPage = strpos($currentPath, '/info') !== false;
$showInfoFab = !$isInfoPage;
if ($showInfoFab): ?>
    <a href="/info/" class="info-fab site-fab" title="Информация" aria-label="Перейти к информации">
      <i class="fas fa-info-circle"></i>
    </a>
<?php endif;
if ($isInfoPage): ?>
    <a href="/" class="home-fab site-fab" title="На главную" aria-label="На главную">
      <i class="fas fa-home"></i>
    </a>
<?php endif; ?>

    <!-- Schema.org: спортивная организация для поисковиков -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SportsOrganization",
      "name": "РФОИ — Раменское Футбол Открытые Игры",
      "alternateName": "РФОИ",
      "description": "Любительский футбол в Раменском — открытые игры, турниры, рейтинги игроков. Раменское, Московская область.",
      "url": "https://football.pavelsolntsev.ru",
      "sport": "Футбол",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Раменское",
        "addressRegion": "Московская область",
        "addressCountry": "RU"
      },
      "sameAs": [
        "https://vk.com/rmsfootball",
        "https://t.me/RmsFootball",
        "https://tournament.pavelsolntsev.ru"
      ]
    }
    </script>
    <!-- JS: defer — не блокируют парсинг HTML, выполняются после загрузки DOM -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    {% block scripts %}
    <?php
    $currentPath = $_SERVER['REQUEST_URI'];
    if (strpos($currentPath, '/tournament') !== false) {
        $tournamentJsVersion = file_exists($_SERVER['DOCUMENT_ROOT'] . '/tournament/script.js') ? filemtime($_SERVER['DOCUMENT_ROOT'] . '/tournament/script.js') : time();
    ?>
    <script type="module" src="tournament/script.js?v=<?= $tournamentJsVersion ?>"></script>
    <?php
    } else {
    ?>
    <script src="js/script.js?v=<?= $jsVersion ?>" defer></script>
    <?php
    }
    ?>
    {% endblock %}
</body>

</html>