<div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="playerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="header-content">
          <i class="fas fa-user-circle user-icon"></i>
          <h5 class="modal-title" id="playerModalLabel">Профиль игрока</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="player-profile">
          
          <div class="player-photo-container">
            <div class="photo-frame">
              <img id="modal-player-photo" src="" alt="Player Photo" class="player-photo-img">
              <div class="photo-overlay"></div>
            </div>
          </div>
          <h3 id="modal-player-name" class="player-name"></h3>

          <div class="rating-container">
            <div class="rating-badge">
              <span class="rating-label">Рейтинг</span>
              <span id="modal-player-rating" class="rating-value"></span>
            </div>
          </div>

          <div class="stats-grid">
            <!-- Swiper для мобильных -->
            <div class="swiper stats-swiper">
              <div class="swiper-wrapper">
                <!-- Слайд 1: 3 карточки в ряд -->
                <div class="swiper-slide">
                  <div class="stats-slide-grid">
                    <div class="stat-card wins">
                      <div class="stat-icon">
                        <i class="fas fa-trophy"></i>
                      </div>
                      <div class="stat-info">
                        <span class="stat-label">Победы</span>
                        <span id="modal-player-wins" class="stat-value"></span>
                      </div>
                    </div>
                    <div class="stat-card draws">
                      <div class="stat-icon">
                        <i class="fas fa-handshake"></i>
                      </div>
                      <div class="stat-info">
                        <span class="stat-label">Ничьи</span>
                        <span id="modal-player-draws" class="stat-value"></span>
                      </div>
                    </div>
                    <div class="stat-card losses">
                      <div class="stat-icon">
                        <i class="fas fa-times-circle"></i>
                      </div>
                      <div class="stat-info">
                        <span class="stat-label">Поражения</span>
                        <span id="modal-player-losses" class="stat-value"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Слайд 2: 1 карточка -->
                <div class="swiper-slide">
                  <div class="stats-slide-grid">
                    <div class="stat-card goals">
                      <div class="stat-icon">
                        <i class="fas fa-futbol"></i>
                      </div>
                      <div class="stat-info">
                        <span class="stat-label">Голы</span>
                        <span id="modal-player-goals" class="stat-value"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Слайд 3: 1 карточка -->
                <div class="swiper-slide">
                  <div class="stats-slide-grid">
                    <div class="stat-card games">
                      <div class="stat-icon">
                        <i class="fas fa-running"></i>
                      </div>
                      <div class="stat-info">
                        <span class="stat-label">Игры</span>
                        <span id="modal-player-games" class="stat-value"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>
            <!-- Сетка для десктопа -->
            <div class="stats-grid-desktop">
              <div class="stat-card wins">
                <div class="stat-icon">
                  <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-info">
                  <span class="stat-label">Победы</span>
                  <span id="modal-player-wins-desktop" class="stat-value"></span>
                </div>
              </div>
              <div class="stat-card draws">
                <div class="stat-icon">
                  <i class="fas fa-handshake"></i>
                </div>
                <div class="stat-info">
                  <span class="stat-label">Ничьи</span>
                  <span id="modal-player-draws-desktop" class="stat-value"></span>
                </div>
              </div>
              <div class="stat-card losses">
                <div class="stat-icon">
                  <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                  <span class="stat-label">Поражения</span>
                  <span id="modal-player-losses-desktop" class="stat-value"></span>
                </div>
              </div>
              <div class="stat-card goals">
                <div class="stat-icon">
                  <i class="fas fa-futbol"></i>
                </div>
                <div class="stat-info">
                  <span class="stat-label">Голы</span>
                  <span id="modal-player-goals-desktop" class="stat-value"></span>
                </div>
              </div>
              <div class="stat-card games">
                <div class="stat-icon">
                  <i class="fas fa-running"></i>
                </div>
                <div class="stat-info">
                  <span class="stat-label">Игры</span>
                  <span id="modal-player-games-desktop" class="stat-value"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="teamModal" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content team-modal-content">
      <div class="modal-header team-modal-header">
        <h5 class="modal-title" id="teamModalLabel">Состав команды</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body team-modal-body">
        <div class="team-info-wrapper">
          <div class="team-header">
            <div class="team-photo-wrapper">
              <img id="modal-team-photo" src="" alt="Team Photo" class="team-photo">
            </div>
            <h3 id="modal-team-name" class="team-name"></h3>
            <span id="modal-team-trophies"></span>

          </div>

          <div id="modal-team-players" class="team-players-grid">
            <!-- Swiper для мобильных -->
            <div class="swiper team-players-swiper">
              <div class="swiper-wrapper">
                <!-- Игроки будут подставлены сюда -->
              </div>
              <div class="swiper-pagination"></div>
            </div>
            <!-- Сетка для десктопа (скрыта на мобильных) -->
            <div class="team-players-grid-desktop">
              <!-- Игроки будут подставлены сюда -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
