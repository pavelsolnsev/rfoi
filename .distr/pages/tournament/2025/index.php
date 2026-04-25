{% extends 'default.php' %}
{% set PAGE_CLASS = 'page-static' %}

{% block blocks %}
{% include 'tournament2025/block.php' %}
{% endblock %}

{% block scripts %}
<?php
$currentPath = $_SERVER['REQUEST_URI'];
if (strpos($currentPath, '/tournament') !== false && strpos($currentPath, '/2025') === false) {
    $tournamentJsVersion = file_exists($_SERVER['DOCUMENT_ROOT'] . '/tournament/script.js') ? filemtime($_SERVER['DOCUMENT_ROOT'] . '/tournament/script.js') : time();
?>
<script src="tournament/script.js?v=<?= $tournamentJsVersion ?>" defer></script>
<?php
} elseif (strpos($currentPath, '/tournament/2025') !== false || strpos($currentPath, '/tournament2025') !== false) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const rfoiImgV = String(
    (typeof window !== 'undefined' && window.RFOI_IMAGES_V != null) ? window.RFOI_IMAGES_V : '0'
  );

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

  // Анимация стрелки указателя в ссылках
  (function() {
    'use strict';
    
    const links = document.querySelectorAll('.caption-link a');
    
    links.forEach(link => {
      const text = link.textContent;
      if (text.includes('👉')) {
        link.innerHTML = text.replace('👉', '<span class="pointing-arrow">👉</span>');
      }
    });
  })();

  // Обработка попапов команд и сортировки
  const teamsTableBody = document.getElementById('teams-table-body');
  const teamsTable = document.getElementById('teams-table');
  const teamModalElement = document.getElementById('teamModal');
  
  if (!teamsTableBody || !teamsTable || !teamModalElement) {
    return;
  }
  
  const teamModal = new bootstrap.Modal(teamModalElement);
  const initialRows = Array.from(teamsTableBody.querySelectorAll('.team-row'));
  
  if (!initialRows.length) {
    return;
  }
  
  // Сохраняем все команды из data-атрибутов
  let teams = initialRows.map(row => {
    const teamData = row.getAttribute('data-team');
    return teamData ? JSON.parse(teamData) : null;
  }).filter(t => t !== null);
  
  // Конфигурация сортировки
  let sortConfig = {
    key: 'points',
    direction: 'desc'
  };
  
  // Функция сортировки команд
  const sortTeams = (teams, key, direction) => {
    return [...teams].sort((a, b) => {
      let valueA, valueB;
      
      switch (key) {
        case 'index':
          valueA = teams.indexOf(a) + 1;
          valueB = teams.indexOf(b) + 1;
          break;
        case 'name':
          valueA = a.name || '';
          valueB = b.name || '';
          return direction === 'asc' 
            ? valueA.localeCompare(valueB)
            : valueB.localeCompare(valueA);
        case 'games':
          // Сортируем по количеству трофеев
          valueA = a.trophy_count !== undefined ? a.trophy_count : ((a.trophies || '').split('🏆').length - 1);
          valueB = b.trophy_count !== undefined ? b.trophy_count : ((b.trophies || '').split('🏆').length - 1);
          break;
        default:
          valueA = a[key] || 0;
          valueB = b[key] || 0;
      }
      
      if (direction === 'asc') {
        return valueA - valueB;
      }
      return valueB - valueA;
    });
  };
  
  // Обновление индикаторов сортировки
  const updateSortIndicators = () => {
    document.querySelectorAll('#teams-table th span').forEach(span => {
      span.textContent = span.textContent.replace(/[▲▼]/g, '').trim();
    });

    document.querySelectorAll('#teams-table th').forEach(th => {
      const sortKey = th.getAttribute('data-sort');
      if (sortKey && sortKey !== 'index' && sortKey !== 'name' && sortKey !== 'games') {
        const spans = th.querySelectorAll('span');
        const isActive = sortKey === sortConfig.key;
        const indicator = isActive ? (sortConfig.direction === 'asc' ? ' ▲' : ' ▼') : ' ▼';
        
        spans.forEach(span => {
          span.textContent += indicator;
        });
      }
    });
    
    // Добавляем класс к таблице
    if (teamsTable) {
      teamsTable.classList.toggle('table-asc', sortConfig.direction === 'asc');
    }
  };
  
  const renderTable = () => {
    teamsTableBody.innerHTML = "";
    const sortedTeams = sortTeams(teams, sortConfig.key, sortConfig.direction);
    
    // Проверка на пустой список команд
    if (sortedTeams.length === 0) {
      const columnCount = teamsTable.querySelectorAll('thead th').length;
      const emptyRow = `
        <tr class="empty-row">
          <td colspan="${columnCount}" style="text-align: center; padding: 2rem;">
            <i class="fas fa-exclamation-circle"></i>
            <span style="margin-left: 0.5rem;">Список команд пуст</span>
          </td>
        </tr>
      `;
      teamsTableBody.insertAdjacentHTML("beforeend", emptyRow);
      updateSortIndicators();
    return;
  }
    
    sortedTeams.forEach((team, index) => {
      const name = team.name || 'Неизвестно';
      const photo = team.photo || 'img/team/default.webp';
      const trophyCount = team.trophy_count !== undefined ? team.trophy_count : ((team.trophies || '').split('🏆').length - 1);
      const trophiesDisplay = trophyCount >= 2
        ? `<span class="trophy-count">${trophyCount}</span>`
        : (team.trophies || '');
      const tournaments = team.tournaments || 0;
      const points = team.points || 0;
      
      const teamRow = `
        <tr class="team-row" data-team-index="${index}" data-team="${JSON.stringify(team).replace(/"/g, '&quot;')}">
          <td data-label="№">${index + 1}</td>
          <td data-label="Команда">
            <div class="player-info">
              <div class="player-photo">
                <img src="/${photo}?v=${rfoiImgV}" alt="${name}" loading="lazy" decoding="async" onerror="this.src='img/team/logo.webp?v=${rfoiImgV}'">
              </div>
              <span>${name}</span>
            </div>
          </td>
          <td data-label="Трофеи">${trophiesDisplay}</td>
          <td data-label="Турниры">${tournaments}</td>
          <td data-label="Очки">${points}</td>
        </tr>
      `;
      teamsTableBody.insertAdjacentHTML("beforeend", teamRow);
    });
    
    document.querySelectorAll(".team-row").forEach((row) => {
      row.style.cursor = 'pointer';
      row.addEventListener("click", () => {
        const teamIndex = row.getAttribute("data-team-index");
        const team = sortedTeams[teamIndex];
        openTeamModal(team);
      });
    });
    
    updateSortIndicators();
    
    // Анимация появления строк таблицы с задержкой
    setTimeout(() => {
      const rows = teamsTableBody.querySelectorAll(".team-row");
      rows.forEach((row, index) => {
        setTimeout(() => {
          row.classList.add("animate-in");
        }, index * 30); // Задержка 30ms между строками
      });
    }, 100);
  };
  
  const openTeamModal = (team) => {
    if (!team) return;
    
    const modalName = document.getElementById('modal-team-name');
    const modalPhoto = document.getElementById('modal-team-photo');
    const modalPlayers = document.getElementById('modal-team-players');
    const modalTrophies = document.getElementById('modal-team-trophies');
    
    if (!modalName || !modalPhoto || !modalPlayers || !modalTrophies) {
      return;
    }
    
    modalName.textContent = team.name || 'Неизвестно';
    const modalTrophyCount = team.trophy_count !== undefined ? team.trophy_count : ((team.trophies || '').split('🏆').length - 1);
    modalTrophies.innerHTML = modalTrophyCount >= 2
      ? `<span class="trophy-count"><span class="trophy-count-num">${modalTrophyCount}</span></span>`
      : (team.trophies || '');
    modalPhoto.src = '/' + (team.photo || 'img/team/default.webp') + '?v=' + rfoiImgV;
    
    // Находим контейнеры для Swiper и сетки
    const swiperWrapper = modalPlayers.querySelector('.swiper-wrapper');
    const gridDesktop = modalPlayers.querySelector('.team-players-grid-desktop');
    
    // Очищаем контейнеры, если они есть
    if (swiperWrapper) {
      swiperWrapper.innerHTML = '';
    }
    if (gridDesktop) {
      gridDesktop.innerHTML = '';
    }
    
    const players = team.players || [];
    
    if (players.length > 0) {
      const sortedPlayers = [...players].sort((a, b) => {
        const aCap = a.is_captain || false;
        const bCap = b.is_captain || false;
        if (aCap && !bCap) return -1;
        if (!aCap && bCap) return 1;
        return 0;
      });
      
      const playersPerSlide = 5;
      let currentSlidePlayers = [];
      
      sortedPlayers.forEach((player, index) => {
        const captainClass = (player.is_captain) ? ' is-captain' : '';
        const playerItem = `
          <div class="player-card${captainClass}">
          <img src="/${player.photo || 'img/players/default.webp'}?v=${rfoiImgV}" alt="${player.name || ''}" class="player-photo" loading="lazy" decoding="async">
          <div class="player-info">
            <span class="player-name">${player.name || ''}${player.icon ? ' ' + player.icon : ''}</span>
          </div>
          </div>
        `;
        
        // Добавляем в текущий слайд
        currentSlidePlayers.push(playerItem);
        
        // Если набралось 5 игроков или это последний игрок, создаем слайд
        if (currentSlidePlayers.length === playersPerSlide || index === sortedPlayers.length - 1) {
          const slideContent = currentSlidePlayers.join('');
          if (swiperWrapper) {
            swiperWrapper.insertAdjacentHTML('beforeend', `
              <div class="swiper-slide">
                <div class="team-players-slide-grid">
                  ${slideContent}
                </div>
              </div>
            `);
          }
          currentSlidePlayers = [];
        }
        
        // Добавляем в сетку (для десктопа)
        if (gridDesktop) {
          gridDesktop.insertAdjacentHTML('beforeend', playerItem);
        }
      });
      
      // Инициализируем или обновляем Swiper только если есть игроки
      const swiperContainer = modalPlayers.querySelector('.team-players-swiper');
      if (swiperContainer) {
        // Удаляем старый Swiper, если есть
        if (swiperContainer.swiper) {
          swiperContainer.swiper.destroy(true, true);
        }
        
        // Инициализируем новый Swiper только на мобильных
        if (window.innerWidth < 576 && typeof Swiper !== 'undefined') {
          new Swiper(swiperContainer, {
            slidesPerView: 1,
            spaceBetween: 16,
            pagination: {
              el: swiperContainer.querySelector('.swiper-pagination'),
              clickable: true,
            },
          });
        }
      }
    }
    
    teamModal.show();
  };
  
  // Обработчики кликов на заголовки таблицы для сортировки
  document.querySelectorAll('#teams-table th').forEach(th => {
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

