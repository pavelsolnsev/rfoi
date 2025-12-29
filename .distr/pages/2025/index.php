{% extends 'default.php' %}
{% set PAGE_CLASS = 'page-static' %}

{% block blocks %}
{% include 'season2025/block.php' %}
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

  // Обработка попапов игроков
  const desktopTableBody = document.getElementById('desktop-table-body');
  const playerModalElement = document.getElementById('playerModal');
  
  if (!desktopTableBody || !playerModalElement) {
    return;
  }
  
  const playerModal = new bootstrap.Modal(playerModalElement);
  const playerRows = desktopTableBody.querySelectorAll('.player-row');
  
  if (!playerRows.length) {
    return;
  }
  
  const truncateUnicodeString = (str, maxLength) => {
    const chars = [...str];
    if (chars.length > maxLength) {
      return chars.slice(0, maxLength).join('') + '...';
    }
    return str;
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
    const modalAssistsEl = document.getElementById('modal-player-assists');
    const modalSavesEl = document.getElementById('modal-player-saves');
    const modalMvpEl = document.getElementById('modal-player-mvp');
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
    if (modalAssistsEl) modalAssistsEl.textContent = player.assists || 0;
    if (modalSavesEl) modalSavesEl.textContent = player.saves || 0;
    if (modalMvpEl) modalMvpEl.textContent = player.mvp || 0;
    if (modalRatingEl) modalRatingEl.textContent = player.rating || 0;
    
    // Обновляем значения для десктопа
    const modalGamesDesktopEl = document.getElementById('modal-player-games-desktop');
    const modalWinsDesktopEl = document.getElementById('modal-player-wins-desktop');
    const modalDrawsDesktopEl = document.getElementById('modal-player-draws-desktop');
    const modalLossesDesktopEl = document.getElementById('modal-player-losses-desktop');
    const modalGoalsDesktopEl = document.getElementById('modal-player-goals-desktop');
    const modalAssistsDesktopEl = document.getElementById('modal-player-assists-desktop');
    const modalSavesDesktopEl = document.getElementById('modal-player-saves-desktop');
    const modalMvpDesktopEl = document.getElementById('modal-player-mvp-desktop');
    
    if (modalGamesDesktopEl) modalGamesDesktopEl.textContent = player.gamesPlayed || 0;
    if (modalWinsDesktopEl) modalWinsDesktopEl.textContent = player.wins || 0;
    if (modalDrawsDesktopEl) modalDrawsDesktopEl.textContent = player.draws || 0;
    if (modalLossesDesktopEl) modalLossesDesktopEl.textContent = player.losses || 0;
    if (modalGoalsDesktopEl) modalGoalsDesktopEl.textContent = player.goals || 0;
    if (modalAssistsDesktopEl) modalAssistsDesktopEl.textContent = player.assists || 0;
    if (modalSavesDesktopEl) modalSavesDesktopEl.textContent = player.saves || 0;
    if (modalMvpDesktopEl) modalMvpDesktopEl.textContent = player.mvp || 0;
    
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
  
  playerRows.forEach((row) => {
    row.style.cursor = 'pointer';
    row.addEventListener('click', () => {
      const playerData = row.getAttribute('data-player');
      if (playerData) {
        try {
          const player = JSON.parse(playerData);
          showPlayerModal(player);
        } catch (e) {
          console.error('Ошибка парсинга данных игрока:', e);
        }
      }
    });
  });
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

