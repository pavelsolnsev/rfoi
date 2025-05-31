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