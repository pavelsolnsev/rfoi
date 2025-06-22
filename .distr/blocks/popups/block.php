<div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="playerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="playerModalLabel">Профиль игрока</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <div class="player-profile">
          <div class="player-photo text-center mb-3">
            <img id="modal-player-photo" src="" alt="Player Photo" class="rounded-circle">
          </div>
          <h4 id="modal-player-name" class="text-center mb-3"></h4>
          <div class="rating-container">
            <span id="modal-player-rating" class="stat-value"></span>
          </div>
          <div class="results-container">
            <div class="stat-item wins">
              <span class="stat-label">Победы</span>
              <span id="modal-player-wins" class="stat-value"></span>
            </div>
            <div class="stat-item draws">
              <span class="stat-label">Ничьи</span>
              <span id="modal-player-draws" class="stat-value"></span>
            </div>
            <div class="stat-item losses">
              <span class="stat-label">Поражения</span>
              <span id="modal-player-losses" class="stat-value"></span>
            </div>
          </div>
          <div class="stats-container">
            <div class="stat-item games">
              <span class="stat-label">Игры</span>
              <span id="modal-player-games" class="stat-value"></span>
            </div>
            <div class="stat-item goals">
              <span class="stat-label">Голы</span>
              <span id="modal-player-goals" class="stat-value"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>