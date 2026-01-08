{% extends 'default.php' %}
{% set PAGE_CLASS = 'page-static' %}

{% block blocks %}
{% include 'season2025/block.php' %}
{% endblock %}

{% block popups %}
{% include 'popups2025/block.php' %}
{% endblock %}

{% block scripts %}
<?php
$currentPath = $_SERVER['REQUEST_URI'];
if (strpos($currentPath, '/tournament') !== false) {
    $tournamentJsVersion = file_exists($_SERVER['DOCUMENT_ROOT'] . '/tournament/script.js') ? filemtime($_SERVER['DOCUMENT_ROOT'] . '/tournament/script.js') : time();
?>
<script src="tournament/script.js?v=<?= $tournamentJsVersion ?>" defer></script>
<?php
} elseif (strpos($currentPath, '/2025') !== false) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Модуль переключения темы (темная/светлая)
  (function() {
    'use strict';
    
    const themeToggle = document.querySelector(".caption-content-icon img");

    if (themeToggle) {
      // Восстановление темы из localStorage
      const savedTheme = localStorage.getItem("theme");
      if (savedTheme) {
        document.body.setAttribute("data-theme", savedTheme);
        updateThemeIcon(savedTheme === "dark");
      }

      themeToggle.addEventListener("click", () => {
        const body = document.body;
        const isDark = body.getAttribute("data-theme") === "dark";
        const newTheme = isDark ? "light" : "dark";

        body.setAttribute("data-theme", newTheme);
        localStorage.setItem("theme", newTheme);
        updateThemeIcon(!isDark);
      });

      function updateThemeIcon(isDark) {
        themeToggle.src = isDark ? "img/main/light.svg" : "img/main/dark.svg";
      }
    }
  })();

  // Обработка попапов игроков и сортировки
  const desktopTableBody = document.getElementById('desktop-table-body');
  const desktopTable = document.getElementById('desktop-table');
  const playerModalElement = document.getElementById('playerModal');
  
  if (!desktopTableBody || !desktopTable || !playerModalElement) {
    return;
  }
  
  const playerModal = new bootstrap.Modal(playerModalElement);
  
  // Сохраняем все игроки из data-атрибутов
  const initialRows = Array.from(desktopTableBody.querySelectorAll('.player-row'));
  
  if (!initialRows.length) {
    return;
  }
  
  let players = initialRows.map(row => {
    const playerData = row.getAttribute('data-player');
    return playerData ? JSON.parse(playerData) : null;
  }).filter(p => p !== null);
  
  // Конфигурация сортировки
  let sortConfig = {
    key: 'rating',
    direction: 'desc'
  };
  
  const truncateUnicodeString = (str, maxLength) => {
    const chars = [...str];
    if (chars.length > maxLength) {
      return chars.slice(0, maxLength).join('') + '...';
    }
    return str;
  };
  
  // Функция сортировки игроков
  const sortPlayers = (players, key, direction) => {
    return [...players].sort((a, b) => {
      let valueA, valueB;
      
      switch (key) {
        case 'index':
          valueA = players.indexOf(a) + 1;
          valueB = players.indexOf(b) + 1;
          break;
        case 'name':
          valueA = a.username === "@unknown" ? a.name : a.username.replace(/@/g, "");
          valueB = b.username === "@unknown" ? b.name : b.username.replace(/@/g, "");
          return direction === 'asc' 
            ? valueA.localeCompare(valueB)
            : valueB.localeCompare(valueA);
        default:
          valueA = a[key];
          valueB = b[key];
      }
      
      if (direction === 'asc') {
        return valueA - valueB;
      }
      return valueB - valueA;
    });
  };
  
  // Обновление индикаторов сортировки
  const updateSortIndicators = () => {
    document.querySelectorAll('.players-table th span').forEach(span => {
      span.textContent = span.textContent.replace(/[▲▼]/g, '').trim();
    });

    document.querySelectorAll('.players-table th').forEach(th => {
      const sortKey = th.getAttribute('data-sort');
      if (sortKey && sortKey !== 'index' && sortKey !== 'name') {
        const spans = th.querySelectorAll('span');
        const isActive = sortKey === sortConfig.key;
        const indicator = isActive ? (sortConfig.direction === 'asc' ? ' ▲' : ' ▼') : ' ▼';
        
        spans.forEach(span => {
          span.textContent += indicator;
        });
      }
    });
  };
  
  // Функция рендеринга таблицы
  const renderTable = () => {
    desktopTableBody.innerHTML = "";
    const sortedPlayers = sortPlayers(players, sortConfig.key, sortConfig.direction);
    
    desktopTable.classList.toggle('table-asc', sortConfig.direction === 'asc');
    
    // Проверка на пустой список игроков
    if (sortedPlayers.length === 0) {
      const columnCount = desktopTable.querySelectorAll('thead th').length;
      const emptyRow = `
        <tr class="empty-row">
          <td colspan="${columnCount}" style="text-align: center; padding: 2rem;">
            <i class="fas fa-exclamation-circle"></i>
            <span style="margin-left: 0.5rem;">Список игроков пуст</span>
          </td>
        </tr>
      `;
      desktopTableBody.insertAdjacentHTML("beforeend", emptyRow);
      updateSortIndicators();
      return;
    }
    
    sortedPlayers.forEach((player, index) => {
      let name = (player.username === "@unknown" || !player.username)
        ? (player.name || 'Неизвестно')
        : player.username.replace(/@/g, "");
      
      const desktopRow = `
        <tr class="player-row" data-player-index="${index}">
          <td data-label="№">${index + 1}</td>
          <td data-label="Игрок">
            <div class="player-info">
              <div class="player-photo"> 
                <img src="/img/players/${player.photo || 'default.jpg'}?v=1.1.7" alt="${name}" class="">
              </div>
              <span>${name}</span>
            </div>
          </td>
          <td data-label="Игры">${player.gamesPlayed || 0}</td>
          <td data-label="Победы">${player.wins || 0}</td>
          <td data-label="Ничьи">${player.draws || 0}</td>
          <td data-label="Поражения">${player.losses || 0}</td>
          <td data-label="Голы">${player.goals || 0}</td>
          <td data-label="Рейтинг">${player.rating || 0}</td>
        </tr>
      `;
      desktopTableBody.insertAdjacentHTML("beforeend", desktopRow);
    });
    
    document.querySelectorAll(".player-row").forEach((row) => {
      row.style.cursor = 'pointer';
      row.addEventListener("click", () => {
        const playerIndex = row.getAttribute("data-player-index");
        const player = sortedPlayers[playerIndex];
        showPlayerModal(player);
      });
    });
    
    updateSortIndicators();
    
    // Анимация появления строк таблицы с задержкой
    setTimeout(() => {
      const rows = desktopTableBody.querySelectorAll(".player-row");
      rows.forEach((row, index) => {
        setTimeout(() => {
          row.classList.add("animate-in");
        }, index * 30); // Задержка 30ms между строками
      });
    }, 100);
  };
  
  const showPlayerModal = (player) => {
    if (!player) return;
    
    let name = (player.username === '@unknown' || !player.username)
      ? (player.name || 'Неизвестно')
      : player.username.replace(/@/g, '');
    name = truncateUnicodeString(name, 30);
    
    const modalNameEl = document.getElementById('modal-player-name');
    const modalPhotoEl = document.getElementById('modal-player-photo');
    const modalGamesEl = document.getElementById('modal-player-games');
    const modalWinsEl = document.getElementById('modal-player-wins');
    const modalDrawsEl = document.getElementById('modal-player-draws');
    const modalLossesEl = document.getElementById('modal-player-losses');
    const modalGoalsEl = document.getElementById('modal-player-goals');
    const modalRatingEl = document.getElementById('modal-player-rating');
    
    if (modalNameEl) modalNameEl.textContent = name;
    if (modalPhotoEl) {
      modalPhotoEl.src = `/img/players/${player.photo || 'default.jpg'}?v=1.1.7`;
      modalPhotoEl.alt = name;
    }
    
    // Обновляем значения для мобильных (Swiper)
    if (modalGamesEl) modalGamesEl.textContent = player.gamesPlayed || 0;
    if (modalWinsEl) modalWinsEl.textContent = player.wins || 0;
    if (modalDrawsEl) modalDrawsEl.textContent = player.draws || 0;
    if (modalLossesEl) modalLossesEl.textContent = player.losses || 0;
    if (modalGoalsEl) modalGoalsEl.textContent = player.goals || 0;
    if (modalRatingEl) modalRatingEl.textContent = player.rating || 0;
    
    // Обновляем значения для десктопа
    const modalGamesDesktopEl = document.getElementById('modal-player-games-desktop');
    const modalWinsDesktopEl = document.getElementById('modal-player-wins-desktop');
    const modalDrawsDesktopEl = document.getElementById('modal-player-draws-desktop');
    const modalLossesDesktopEl = document.getElementById('modal-player-losses-desktop');
    const modalGoalsDesktopEl = document.getElementById('modal-player-goals-desktop');
    
    if (modalGamesDesktopEl) modalGamesDesktopEl.textContent = player.gamesPlayed || 0;
    if (modalWinsDesktopEl) modalWinsDesktopEl.textContent = player.wins || 0;
    if (modalDrawsDesktopEl) modalDrawsDesktopEl.textContent = player.draws || 0;
    if (modalLossesDesktopEl) modalLossesDesktopEl.textContent = player.losses || 0;
    if (modalGoalsDesktopEl) modalGoalsDesktopEl.textContent = player.goals || 0;
    
    // Инициализируем Swiper для статистики на мобильных
    const statsSwiperEl = document.querySelector('.stats-swiper');
    if (statsSwiperEl && window.innerWidth < 576 && typeof Swiper !== 'undefined') {
      // Удаляем старый Swiper, если есть
      if (statsSwiperEl.swiper) {
        statsSwiperEl.swiper.destroy(true, true);
      }
      
      new Swiper(statsSwiperEl, {
        slidesPerView: 1,
        spaceBetween: 16,
        pagination: {
          el: statsSwiperEl.querySelector('.swiper-pagination'),
          clickable: true,
        },
      });
    }
    
    playerModal.show();
  };
  
  // Обработчики кликов на заголовки таблицы для сортировки
  document.querySelectorAll('.players-table th').forEach(th => {
    const sortKey = th.getAttribute('data-sort');
    if (sortKey) {
      th.style.cursor = 'pointer';
      th.addEventListener('click', () => {
        if (sortConfig.key === sortKey) {
          sortConfig.direction = sortConfig.direction === 'asc' ? 'desc' : 'asc';
        } else {
          sortConfig.key = sortKey;
          sortConfig.direction = 'asc';
        }
        renderTable();
      });
    }
  });
  
  // Инициализация таблицы с сортировкой
  renderTable();
});
</script>
<?php
} else {
?>
<script src="js/script.js?v=<?= $jsVersion ?>" defer></script>
<?php
}
?>
{% endblock %}

