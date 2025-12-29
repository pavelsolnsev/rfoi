/**
 * Модуль для работы с модальным окном команды
 */

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

  modalName.textContent = team.name;
  modalTrophies.innerHTML = team.trophies;
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
    // Сортируем игроков: капитан первым
    const sortedPlayers = [...players].sort((a, b) => {
      if (a.isCaptain && !b.isCaptain) return -1;
      if (!a.isCaptain && b.isCaptain) return 1;
      return 0;
    });

    // Группируем игроков по 5 для Swiper
    const playersPerSlide = 5;
    let currentSlidePlayers = [];
    
    sortedPlayers.forEach((player, index) => {
      const captainClass = player.isCaptain ? ' is-captain' : '';
      const playerItem = `
        <div class="player-card${captainClass}">
          <img src="${player.photo}" alt="${player.name}" class="player-photo">
          <div class="player-info">
            <span class="player-name">${player.name}${player.icon ? ' ' + player.icon : ''}</span>
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
  }

  const teamModalElement = document.getElementById("teamModal");
  if (teamModalElement && typeof bootstrap !== 'undefined') {
    const teamModal = new bootstrap.Modal(teamModalElement);
    teamModal.show();
  }
};

