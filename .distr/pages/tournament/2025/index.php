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

  // Обработка попапов команд
  const teamsTableBody = document.getElementById('teams-table-body');
  const teamModalElement = document.getElementById('teamModal');
  
  if (!teamsTableBody || !teamModalElement) {
    return;
  }
  
  const teamModal = new bootstrap.Modal(teamModalElement);
  const teamRows = teamsTableBody.querySelectorAll('.team-row');
  
  if (!teamRows.length) {
    return;
  }
  
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
    modalTrophies.innerHTML = team.trophies || '';
    modalPhoto.src = '/' + (team.photo || 'img/team/default.jpg');
    modalPlayers.innerHTML = '';
    
    if (team.players && Array.isArray(team.players)) {
      team.players.forEach((player) => {
        const playerItem = document.createElement('div');
        playerItem.className = 'player-card';
        playerItem.innerHTML = `
          <img src="/${player.photo || 'img/players/default.jpg'}" alt="${player.name || ''}" class="player-photo">
          <div class="player-info">
            <span class="player-name">${player.name || ''}${player.icon ? ' ' + player.icon : ''}</span>
          </div>
        `;
        modalPlayers.appendChild(playerItem);
      });
    }
    
    teamModal.show();
  };
  
  teamRows.forEach((row) => {
    row.style.cursor = 'pointer';
    row.addEventListener('click', () => {
      const teamData = row.getAttribute('data-team');
      if (teamData) {
        try {
          const team = JSON.parse(teamData);
          openTeamModal(team);
        } catch (e) {
          console.error('Ошибка парсинга данных команды:', e);
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

