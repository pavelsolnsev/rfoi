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
    const modalRatingEl = document.getElementById('modal-player-rating');
    
    if (modalNameEl) modalNameEl.textContent = name;
    if (modalPhotoEl) {
      modalPhotoEl.src = `/img/players/${player.photo || 'default.jpg'}?v=1.1.7`;
      modalPhotoEl.alt = name;
    }
    if (modalGamesEl) modalGamesEl.textContent = player.gamesPlayed || 0;
    if (modalWinsEl) modalWinsEl.textContent = player.wins || 0;
    if (modalDrawsEl) modalDrawsEl.textContent = player.draws || 0;
    if (modalLossesEl) modalLossesEl.textContent = player.losses || 0;
    if (modalGoalsEl) modalGoalsEl.textContent = player.goals || 0;
    if (modalRatingEl) modalRatingEl.textContent = player.rating || 0;
    
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

