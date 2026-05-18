<!-- Попап игрока -->
<div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="playerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content player-modal">

      <!-- Hero: фото, имя, рейтинг -->
      <div class="pm-hero">
        <button class="pm-close" type="button" data-bs-dismiss="modal" aria-label="Закрыть">
          <i class="fas fa-times"></i>
        </button>
        <div class="pm-photo-wrap">
          <img id="modal-player-photo" src="" alt="Фото игрока" class="pm-photo" loading="eager" decoding="async">
        </div>
        <h3 id="modal-player-name" class="pm-name"></h3>
        <div id="modal-player-rank" class="pm-rank"></div>
        <div class="pm-team" id="player-modal-team-info">
          <img id="player-modal-team-logo-img" src="" alt="" class="pm-team-logo" loading="eager" decoding="async">
          <span id="player-modal-team-name" class="pm-team-name"></span>
        </div>
        <div class="pm-rating-pill">
          <span class="pm-rating-label">Рейтинг</span>
          <span id="modal-player-rating" class="pm-rating-value"></span>
        </div>
      </div>

      <!-- Сетка статистики -->
      <div class="pm-stats">
        <div class="pm-stat wins">
          <i class="fas fa-trophy pm-stat-icon"></i>
          <span id="modal-player-wins" class="pm-stat-value"></span>
          <span class="pm-stat-label">Победы</span>
        </div>
        <div class="pm-stat draws">
          <i class="fas fa-handshake pm-stat-icon"></i>
          <span id="modal-player-draws" class="pm-stat-value"></span>
          <span class="pm-stat-label">Ничьи</span>
        </div>
        <div class="pm-stat losses">
          <i class="fas fa-times-circle pm-stat-icon"></i>
          <span id="modal-player-losses" class="pm-stat-value"></span>
          <span class="pm-stat-label">Поражения</span>
        </div>
        <div class="pm-stat games">
          <i class="fas fa-running pm-stat-icon"></i>
          <span id="modal-player-games" class="pm-stat-value"></span>
          <span class="pm-stat-label">Игры</span>
        </div>
        <div class="pm-stat goals">
          <i class="fas fa-futbol pm-stat-icon"></i>
          <span id="modal-player-goals" class="pm-stat-value"></span>
          <span class="pm-stat-label">Голы</span>
        </div>
        <div class="pm-stat assists">
          <i class="fas fa-hand-holding pm-stat-icon"></i>
          <span id="modal-player-assists" class="pm-stat-value"></span>
          <span class="pm-stat-label">Ассисты</span>
        </div>
        <div class="pm-stat saves">
          <i class="fas fa-shield-alt pm-stat-icon"></i>
          <span id="modal-player-saves" class="pm-stat-value"></span>
          <span class="pm-stat-label">Сейвы</span>
        </div>
        <div class="pm-stat mvp">
          <i class="fas fa-star pm-stat-icon"></i>
          <span id="modal-player-mvp" class="pm-stat-value"></span>
          <span class="pm-stat-label">MVP</span>
        </div>
      </div>

      <!-- Скрытые элементы для совместимости с JS (desktop IDs) -->
      <div style="display:none" aria-hidden="true">
        <span id="modal-player-wins-desktop"></span>
        <span id="modal-player-draws-desktop"></span>
        <span id="modal-player-losses-desktop"></span>
        <span id="modal-player-goals-desktop"></span>
        <span id="modal-player-assists-desktop"></span>
        <span id="modal-player-saves-desktop"></span>
        <span id="modal-player-mvp-desktop"></span>
        <span id="modal-player-games-desktop"></span>
      </div>

    </div>
  </div>
</div>

<!-- Попап команды -->
<div class="modal fade" id="teamModal" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content team-modal">

      <!-- Hero команды -->
      <div class="tm-hero">
        <button class="pm-close" type="button" data-bs-dismiss="modal" aria-label="Закрыть">
          <i class="fas fa-times"></i>
        </button>
        <div class="tm-hero-content">
          <div class="tm-logo-wrap">
            <img id="modal-team-photo" src="" alt="Логотип команды" class="tm-logo" loading="eager" decoding="async">
          </div>
          <div class="tm-hero-info">
            <h3 id="modal-team-name" class="tm-name"></h3>
            <div id="modal-team-rank" class="tm-rank"></div>
            <div id="modal-team-trophies" class="tm-trophies"></div>
          </div>
        </div>
      </div>

      <!-- Состав -->
      <div class="tm-body">
        <div class="tm-section-label">Состав</div>
        <div id="modal-team-players" class="team-players-grid">
          <!-- Swiper для мобильных -->
          <div class="swiper team-players-swiper">
            <div class="swiper-wrapper"></div>
            <div class="swiper-pagination"></div>
          </div>
          <!-- Сетка для десктопа -->
          <div class="team-players-grid-desktop"></div>
        </div>
      </div>

    </div>
  </div>
</div>
