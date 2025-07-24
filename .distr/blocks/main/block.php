<section class="s-main">
  <div class="container">
    <!-- Десктопная таблица -->
    <div class="table-wrapper">
      <table id="desktop-table" class="players-table">
        <caption class="table-caption">
          <div class="caption-content">
            <i class="fas fa-trophy trophy-icon"></i>
            <span>Статистика игроков</span>
          </div>
        </caption>
        <thead>
          <tr>
            <th data-sort="index"><span>№</span><span>№</span></th>
            <th data-sort="name"><span>Игрок</span><span>Игрок</span></th>
            <th data-sort="gamesPlayed"><span>И</span><span>Игры</span></th>
            <th data-sort="wins"><span>В</span><span>Победы</span></th>
            <th data-sort="draws"><span>Н</span><span>Ничьи</span></th>
            <th data-sort="losses"><span>П</span><span>Поражения</span></th>
            <th data-sort="goals"><span>Г</span><span>Голы</span></th>
            <th data-sort="rating"><span>Рейт</span><span>Рейтинг</span></th>
            
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