<section class="s-main">
  <div class="container">

    <!-- Десктопная таблица -->
    <div class="table-wrapper">
      <table id="desktop-table" class="players-table">
        <caption class="table-caption">
          <!-- Новогодние снежинки -->
          <!-- <div class="snowflakes">
            <div class="snowflake">❄</div>
            <div class="snowflake">❅</div>
            <div class="snowflake">❆</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❅</div>
            <div class="snowflake">❆</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❅</div>
            <div class="snowflake">❆</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❅</div>
            <div class="snowflake">❆</div>
          </div> -->
          <!-- Новогодние огоньки -->
          <!-- <div class="sparkles">
            <span class="sparkle">✨</span>
            <span class="sparkle">⭐</span>
            <span class="sparkle">✨</span>
            <span class="sparkle">⭐</span>
            <span class="sparkle">✨</span>
            <span class="sparkle">⭐</span>
          </div> -->
          <video class="caption-bg-video" autoplay muted loop playsinline>
            <source src="/bg-video.mp4" type="video/mp4">
          </video>
          <div class="caption-header">
            <div class="caption-brand">
              <img src="img/main/logorfoi.webp" alt="РФОИ" class="caption-brand-logo" loading="lazy">
              <span class="caption-brand-title">
                <i class="fas fa-futbol ball-icon"></i>
                Статистика игроков
              </span>
            </div>
            <div class="caption-content-icon">
              <img src="img/main/dark.svg" loading="lazy" alt="">
            </div>
          </div>
          <div class="caption-link">
            <a id="page-link" href="/tournament">Турнир</a>
            <a id="season-link" href="/2025">Рейтинг 2025</a>
          </div>
        </caption>
        <thead>
          <tr>
            <th data-sort="index"><span>№</span><span>№</span></th>
            <th data-sort="name"><span>Игрок</span><span>Игрок</span></th>
            <th data-sort="gamesPlayed"><span>И</span><span>Игры</span></th>
            <th data-sort="wins"><span>В</span><span>Поб</span></th>
            <th data-sort="draws"><span>Н</span><span>Нич</span></th>
            <th data-sort="losses"><span>П</span><span>Пор</span></th>
            <th data-sort="goals"><span>Г</span><span>Голы</span></th>
            <th data-sort="assists"><span>А</span><span>Асс</span></th>
            <th data-sort="saves"><span>С</span><span>Сейвы</span></th>
            <th data-sort="mvp"><span>M</span><span>MVP</span></th>
            <th data-sort="rating"><span>Р</span><span>Рейт</span></th>

          </tr>
        </thead>
        <tbody id="desktop-table-body">
          <!-- Прелоудер внутри tbody, видимый по умолчанию -->
        </tbody>
      </table>
    </div>

    <div id="loader" class="loader">
      <div class="loader-content">
        <div class="spinner"></div>
        <p>Загрузка данных...</p>
      </div>
    </div>

    <!-- Сообщения -->
    <div id="error-message" class="error-message" style="display: none;"></div>
    <div id="empty-message" class="empty-message" style="display: none;">
      <i class="fas fa-exclamation-circle"></i>
      <span>Список игроков пуст</span>
    </div>
  </div>
</section>