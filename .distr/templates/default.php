<!DOCTYPE html>
<html lang="ru">
<?php
if (!headers_sent()) {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0', true);
    header('Pragma: no-cache', true);
    header('Expires: 0', true);
}

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

$docRoot = rtrim((string)($_SERVER['DOCUMENT_ROOT'] ?? ''), "/\\");
$rfoiImageSignatures = [];
if ($docRoot !== '') {
    foreach (['img/players', 'img/team'] as $sub) {
        $dir = $docRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $sub);
        if (!is_dir($dir)) {
            continue;
        }
        $list = @scandir($dir) ?: [];
        foreach ($list as $name) {
            if ($name === '.' || $name === '..' || (is_string($name) && $name !== '' && $name[0] === '.')) {
                continue;
            }
            $f = $dir . DIRECTORY_SEPARATOR . $name;
            if (is_file($f)) {
                $rfoiImageSignatures[] = $sub . '/' . $name . ':' . filemtime($f) . ':' . filesize($f);
            }
        }
    }
}
sort($rfoiImageSignatures, SORT_STRING);
$rfoiImagesVersion = $rfoiImageSignatures
    ? (int) sprintf('%u', crc32(implode("\0", $rfoiImageSignatures)))
    : (int) time();
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

    <title>РФОИ</title>
    <meta property="og:title" content="РФОИ">
    <meta property="og:description" content="">
    <meta property="og:url" content="//<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    <meta property="og:image" content="//<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>img/common/share.jpg?v=1.0.1">
    <link rel="image_src" href="//<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>img/common/share.jpg?v=1.0.1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml" sizes="any">
    <link rel="stylesheet" href="css/style.css?v=<?= $cssVersion ?>">
    <script>window.RFOI_IMAGES_V=<?= (int)$rfoiImagesVersion ?>;</script>
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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