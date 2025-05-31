<!DOCTYPE html>
<html lang="ru">
<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'] . '/';
$BASE_HREF = '//' . $_SERVER['HTTP_HOST'] . (!empty($_SERVER['DOCUMENT_URI']) ? str_replace(substr(str_replace('index.php', '', $_SERVER['DOCUMENT_URI']), 1), '', $_SERVER['REQUEST_URI']) : '');
$URL = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$query_string = http_build_query($_GET);
function isMobile() {
    return preg_match('/(android|iphone|ipad|mobile)/i', $_SERVER['HTTP_USER_AGENT']);
}
$cssVersion = filemtime($_SERVER['DOCUMENT_ROOT'] . '/css/style.css');
$jsVersion = filemtime($_SERVER['DOCUMENT_ROOT'] . '/js/script.js');
?>

<head>
    <base href="<?= $BASE_HREF . ($query_string ? '?' . $query_string : '') ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <link href="/favicon.ico" type="image/x-icon" rel="icon">
    <link rel="stylesheet" href="css/style.css?v=<?= $cssVersion ?>">
</head>

<body class="">
    <div class="wrapper">
        
        <section class="s-main">
  <div class="container">



    <!-- Десктопная таблица -->
    <table id="desktop-table" class="players-table">
      <caption class="table-caption">Статистика игроков</caption>
      <thead>
        <tr>
          <th><span>№</span><span>№</span></th>
          <th><span>Игрок</span><span>Игрок</span></th>
          <th><span>И</span><span>Игры</span></th>
          <th><span>В</span><span>Победы</span></th>
          <th><span>Н</span><span>Ничьи</span></th>
          <th><span>П</span><span>Поражения</span></th>
          <th><span>Г</span><span>Голы</span></th>
          <th><span>Рейт</span><span>Рейтинг</span></th>
        </tr>
      </thead>
      <tbody id="desktop-table-body">
        <!-- Прелоудер внутри tbody, видимый по умолчанию -->

      </tbody>
    </table>

    <div id="loader" class="loader">
      <div class="loader-content">
        <div class="spinner"></div>
        <p>Загрузка данных...</p>
      </div>
    </div>


    <!-- Сообщения -->
    <div id="error-message" class="error-message" style="display: none;"></div>
    <div id="empty-message" class="empty-message" style="display: none;">Список игроков пуст</div>
  </div>
</section>
        
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/script.js?v=<?= $jsVersion ?>" defer></script>
</body>
</html>