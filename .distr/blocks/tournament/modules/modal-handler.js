/**
 * Модуль для работы с модальным окном команды
 */

import { truncateUnicodeString, getMaxTeamNameLength } from './format-utils.js';

/**
 * Функция открытия модального окна команды
 * @param {Object} team - Объект команды
 */
export const openTeamModal = (team) => {
  const modalName = document.getElementById("modal-team-name");
  const modalPhoto = document.getElementById("modal-team-photo");
  const modalPlayers = document.getElementById("modal-team-players");
  const modalTrophies = document.getElementById("modal-team-trophies");

  if (!modalName || !modalPhoto || !modalPlayers || !modalTrophies) {
    return; // Элементы модального окна не найдены
  }

  // Сокращаем название команды
  const maxNameLength = getMaxTeamNameLength();
  const truncatedTeamName = truncateUnicodeString(team.name, maxNameLength);
  modalName.textContent = truncatedTeamName;
  
  // Форматируем трофеи: если больше 3, показываем число и одну иконку
  let trophiesDisplay = team.trophies || '';
  const trophyCount = (trophiesDisplay.match(/🏆/g) || []).length;
  if (trophyCount > 3) {
    trophiesDisplay = `<span class="trophy-count">${trophyCount}</span><span class="trophy-icon-single">🏆</span>`;
  }
  modalTrophies.innerHTML = trophiesDisplay;

  const fallbackTeamLogoPath = '/img/team/logo.jpg';
  modalPhoto.onerror = function () {
    modalPhoto.onerror = null;
    modalPhoto.src = fallbackTeamLogoPath;
  };
  modalPhoto.src = team.photo;

  // Находим контейнеры для Swiper и сетки
  const swiperWrapper = modalPlayers.querySelector('.swiper-wrapper');
  const gridDesktop = modalPlayers.querySelector('.team-players-grid-desktop');
  
  // Очищаем контейнеры, если они есть
  if (swiperWrapper) {
    swiperWrapper.innerHTML = "";
  }
  if (gridDesktop) {
    gridDesktop.innerHTML = "";
  }

  // Проверяем наличие игроков
  const players = team.players || [];
  
  if (players.length > 0) {
    // Сортируем игроков: капитан первым, затем основной игрок
    const sortedPlayers = [...players].sort((a, b) => {
      // Капитаны идут первыми
      if (a.isCaptain && !b.isCaptain) return -1;
      if (!a.isCaptain && b.isCaptain) return 1;

      // Если оба капитаны или оба не капитаны, проверяем основных игроков
      if (a.isMainPlayer && !b.isMainPlayer) return -1;
      if (!a.isMainPlayer && b.isMainPlayer) return 1;

      return 0;
    });

    // Группируем игроков по 5 для Swiper
    const playersPerSlide = 5;
    let currentSlidePlayers = [];
    
    sortedPlayers.forEach((player, index) => {
      const captainClass = player.isCaptain ? ' is-captain' : '';
      const mainPlayerClass = player.isMainPlayer ? ' is-main-player' : '';
      
      // Формируем путь к фото игрока (нормализуем путь)
      let playerPhoto = player.photo || 'default.jpg';
      if (!playerPhoto.startsWith('/') && !playerPhoto.startsWith('img/') && !playerPhoto.startsWith('http')) {
        playerPhoto = `/img/players/${playerPhoto}`;
      } else if (playerPhoto.startsWith('img/')) {
        playerPhoto = `/${playerPhoto}`;
      }
      
      // Формируем отображаемое имя так же, как в showPlayerModal
      // Если у игрока есть username и он не "@unknown", используем username без @, иначе name
      // Но здесь player.name уже может быть username из api-loader, поэтому нужно проверить
      const displayName = player.username && player.username !== "@unknown" 
        ? player.username.replace(/@/g, "")
        : (player.name || '');
      
      // Для data-атрибутов используем оригинальное имя из базы (для поиска)
      // Но в api-loader name уже формируется как username || name, поэтому нужно сохранить оба
      const playerNameForSearch = player.name || '';
      const playerUsernameForSearch = player.username || '';
      
      // Экранируем имя и username для использования в data-атрибутах
      const playerNameEscaped = playerNameForSearch.replace(/"/g, '&quot;');
      const playerUsernameEscaped = playerUsernameForSearch.replace(/"/g, '&quot;');
      const displayNameEscaped = displayName.replace(/"/g, '&quot;');
      const playerItem = `
        <div class="player-card${captainClass}${mainPlayerClass}" data-player-name="${playerNameEscaped}" data-player-username="${playerUsernameEscaped}" style="cursor: pointer;">
          <img src="${playerPhoto}" alt="${displayName}" class="player-photo">
          <div class="player-info">
            <span class="player-name">${displayName}${player.icon ? ' ' + player.icon : ''}</span>
          </div>
        </div>
      `;
      
      // Добавляем в текущий слайд
      currentSlidePlayers.push(playerItem);
      
      // Если набралось 5 игроков или это последний игрок, создаем слайд
      if (currentSlidePlayers.length === playersPerSlide || index === sortedPlayers.length - 1) {
        const slideContent = currentSlidePlayers.join('');
        if (swiperWrapper) {
          swiperWrapper.insertAdjacentHTML("beforeend", `
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
        gridDesktop.insertAdjacentHTML("beforeend", playerItem);
      }
    });
  }

  // Инициализируем или обновляем Swiper только если есть игроки
  if (players.length > 0) {
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

    // Добавляем обработчики клика на карточки игроков после инициализации Swiper
    setTimeout(() => {
      const allPlayerCards = modalPlayers.querySelectorAll('.player-card');
      allPlayerCards.forEach((card) => {
        card.addEventListener('click', (e) => {
          e.stopPropagation();
          const playerName = card.getAttribute('data-player-name');
          const playerUsername = card.getAttribute('data-player-username');
          if (!playerName) return;

          // Загружаем данные игроков и открываем попап (team.name — для отображения лого команды и fallback logo.jpg)
          loadAndShowPlayerModal(playerName, playerUsername, teamModalElement, team.name);
        });
      });
    }, 100);
  }

  const teamModalElement = document.getElementById("teamModal");
  if (teamModalElement && typeof bootstrap !== 'undefined') {
    const teamModal = new bootstrap.Modal(teamModalElement);
    teamModal.show();
  }
};

/**
 * Функция для загрузки данных игрока и открытия его попапа
 */
const loadAndShowPlayerModal = async (playerName, playerUsername, teamModalElement, teamNameFromContext) => {
  try {
    if (teamModalElement) {
      const teamModalInstance = bootstrap.Modal.getInstance(teamModalElement);
      if (teamModalInstance) {
        teamModalInstance.hide();
      }
    }

    const response = await fetch(`https://football.pavelsolntsev.ru/api/players.php?t=${Date.now()}`);
    if (!response.ok) {
      console.error("Ошибка загрузки игроков");
      return;
    }
    const players = await response.json();

    const player = players.find(p => {
      const playerDisplayName = p.username === "@unknown" ? p.name : p.username.replace(/@/g, "");
      if (playerDisplayName === playerName || p.name === playerName) return true;
      if (playerUsername && (p.username === playerUsername || p.username === `@${playerUsername}`)) return true;
      return false;
    });

    if (player) {
      showPlayerModalInTournament(player, teamNameFromContext);
    }
  } catch (error) {
    console.error("Ошибка при загрузке игрока:", error);
  }
};

/**
 * Функция для открытия попапа игрока на странице турнира
 */
const showPlayerModalInTournament = (player, teamNameFromContext) => {
  const playerModalElement = document.getElementById("playerModal");
  if (!playerModalElement) return;

  const name = player.username === "@unknown" ? player.name : player.username.replace(/@/g, "");

  document.getElementById("modal-player-name").textContent = name;
  document.getElementById("modal-player-photo").src = `/img/players/${player.photo}?v=1.1.7`;
  document.getElementById("modal-player-photo").alt = name;

  const displayTeamName = teamNameFromContext || player.teamName;

  const teamNameMap = {
    'РФОИ': 'admin.png',
    'Леон': 'leon.webp',
    'Ручеёк': 'rych.webp',
    'Worlds': 'worlds.png',
    'Volt': 'volt.webp',
    'California': 'california.webp',
    'Юность': 'un.webp',
    'Engelbert': 'Engelbert.png',
    'Ясность': 'iasnostb.jpg'
  };

  const teamInfo = document.getElementById("player-modal-team-info");
  const teamLogoImg = document.getElementById("player-modal-team-logo-img");
  const teamNameElement = document.getElementById("player-modal-team-name");

  if (teamInfo && teamLogoImg && teamNameElement) {
    if (displayTeamName) {
      const teamFileName = teamNameMap[displayTeamName] ||
        displayTeamName.toLowerCase()
          .replace(/\s+/g, '')
          .replace(/ё/g, 'e')
          .replace(/й/g, 'i') + '.webp';

      const teamPhotoPath = `/img/team/${teamFileName}`;
      const fallbackLogoPath = '/img/team/logo.jpg';
      teamLogoImg.onerror = function () {
        teamLogoImg.onerror = null;
        teamLogoImg.src = fallbackLogoPath;
      };
      teamLogoImg.src = teamPhotoPath;
      teamLogoImg.alt = displayTeamName;
      teamNameElement.textContent = displayTeamName;
      teamInfo.style.display = "flex";

      teamInfo.onclick = (e) => {
        e.stopPropagation();
        const playerModalInstance = bootstrap.Modal.getInstance(playerModalElement);
        if (playerModalInstance) {
          playerModalInstance.hide();
        }
        loadAndOpenTeamModal(displayTeamName);
      };
      teamInfo.style.cursor = "pointer";
    } else {
      teamInfo.style.display = "none";
      teamInfo.onclick = null;
      teamInfo.style.cursor = "default";
    }
  }

  // Обновляем статистику
  document.getElementById("modal-player-games").textContent = player.gamesPlayed || 0;
  document.getElementById("modal-player-wins").textContent = player.wins || 0;
  document.getElementById("modal-player-draws").textContent = player.draws || 0;
  document.getElementById("modal-player-losses").textContent = player.losses || 0;
  document.getElementById("modal-player-goals").textContent = player.goals || 0;
  document.getElementById("modal-player-assists").textContent = player.assists || 0;
  document.getElementById("modal-player-saves").textContent = player.saves || 0;
  document.getElementById("modal-player-mvp").textContent = player.mvp || 0;

  // Для десктопа
  const gamesDesktop = document.getElementById("modal-player-games-desktop");
  if (gamesDesktop) gamesDesktop.textContent = player.gamesPlayed || 0;
  const winsDesktop = document.getElementById("modal-player-wins-desktop");
  if (winsDesktop) winsDesktop.textContent = player.wins || 0;
  const drawsDesktop = document.getElementById("modal-player-draws-desktop");
  if (drawsDesktop) drawsDesktop.textContent = player.draws || 0;
  const lossesDesktop = document.getElementById("modal-player-losses-desktop");
  if (lossesDesktop) lossesDesktop.textContent = player.losses || 0;
  const goalsDesktop = document.getElementById("modal-player-goals-desktop");
  if (goalsDesktop) goalsDesktop.textContent = player.goals || 0;
  const assistsDesktop = document.getElementById("modal-player-assists-desktop");
  if (assistsDesktop) assistsDesktop.textContent = player.assists || 0;
  const savesDesktop = document.getElementById("modal-player-saves-desktop");
  if (savesDesktop) savesDesktop.textContent = player.saves || 0;
  const mvpDesktop = document.getElementById("modal-player-mvp-desktop");
  if (mvpDesktop) mvpDesktop.textContent = player.mvp || 0;

  document.getElementById("modal-player-rating").textContent = player.rating || 0;

  // Инициализируем Swiper для статистики на мобильных
  const statsSwiperContainer = document.querySelector('.stats-swiper');
  if (statsSwiperContainer && window.innerWidth < 576 && typeof Swiper !== 'undefined') {
    if (statsSwiperContainer.swiper) {
      statsSwiperContainer.swiper.destroy(true, true);
    }
    
    new Swiper(statsSwiperContainer, {
      slidesPerView: 1,
      spaceBetween: 16,
      pagination: {
        el: statsSwiperContainer.querySelector('.swiper-pagination'),
        clickable: true,
      },
    });
  }

  const playerModal = new bootstrap.Modal(playerModalElement);
  playerModal.show();
};

/**
 * Функция для загрузки данных команды и открытия её попапа
 */
const loadAndOpenTeamModal = async (teamName) => {
  try {
    // Загружаем данные команд
    const teamsResponse = await fetch(`https://football.pavelsolntsev.ru/api/teams.php?t=${Date.now()}`);
    if (!teamsResponse.ok) {
      console.error("Ошибка загрузки команд");
      return;
    }
    const teams = await teamsResponse.json();
    
    // Находим команду по названию
    const team = teams.find(t => t.name === teamName);
    if (!team) {
      console.error("Команда не найдена");
      return;
    }

    // Загружаем игроков команды
    const playersResponse = await fetch(`https://football.pavelsolntsev.ru/api/team_players.php?team_id=${team.id}&t=${Date.now()}`);
    if (!playersResponse.ok) {
      console.error("Ошибка загрузки игроков команды");
      return;
    }
    const teamData = await playersResponse.json();

    // Маппинг названий команд к файлам логотипов
    const teamNameMap = {
      'РФОИ': 'admin.png',
      'Леон': 'leon.webp',
      'Ручеёк': 'rych.webp',
      'Worlds': 'worlds.png',
      'Volt': 'volt.webp',
      'California': 'california.webp',
      'Un': 'un.webp',
      'Engelbert': 'Engelbert.png',
      'Ясность': 'iasnostb.jpg'
    };

    // Формируем путь к фото команды
    const teamFileName = teamNameMap[team.name] || 
      team.name.toLowerCase()
        .replace(/\s+/g, '')
        .replace(/ё/g, 'e')
        .replace(/й/g, 'i') + '.webp';
    const teamPhotoPath = `/img/team/${teamFileName}`;

    // Открываем попап команды используя существующую функцию
    const teamForModal = {
      name: team.name,
      photo: teamPhotoPath,
      trophies: team.trophies ? '🏆'.repeat(team.trophies) : '',
      players: teamData.players ? teamData.players.map(p => {
        // Нормализуем путь к фото игрока
        let photo = p.photo || 'default.jpg';
        if (!photo.startsWith('/') && !photo.startsWith('img/') && !photo.startsWith('http')) {
          photo = `/img/players/${photo}`;
        } else if (photo.startsWith('img/')) {
          photo = `/${photo}`;
        }
        
        return {
          name: p.name,
          username: p.username || null,
          photo: photo,
          isCaptain: p.is_captain || false,
          isMainPlayer: p.is_main_player || false,
          icon: p.yellow_cards > 0 ? '🟨'.repeat(Math.min(p.yellow_cards, 2)) : ''
        };
      }) : []
    };

    openTeamModal(teamForModal);
  } catch (error) {
    console.error("Ошибка при загрузке команды:", error);
  }
};

