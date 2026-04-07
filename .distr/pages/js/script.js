$(function () {


  //=require main/script.js
  //=require popups/script.js

  const desktopTable = document.getElementById("desktop-table");
  const desktopTableBody = document.getElementById("desktop-table-body");
  const errorMessage = document.getElementById("error-message");
  const emptyMessage = document.getElementById("empty-message");
  const loader = document.getElementById("loader");
  const playerModal = new bootstrap.Modal(document.getElementById("playerModal"));

  if (
    !desktopTable ||
    !desktopTableBody ||
    !errorMessage ||
    !emptyMessage ||
    !loader ||
    !playerModal
  ) {
    // console.error("Ошибка: Один или несколько элементов DOM не найдены");
    return;
  }

  let players = [];
  let sortConfig = {
    key: 'rating',
    direction: 'desc'
  };

  // Маппинг названий команд к файлам логотипов (общая переменная)
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

  const renderTable = () => {
    desktopTableBody.innerHTML = "";
    // Если сортировка по умолчанию (рейтинг по убыванию), используем данные как есть (уже отсортированы сервером)
    // Иначе применяем клиентскую сортировку
    const sortedPlayers = (sortConfig.key === 'rating' && sortConfig.direction === 'desc')
      ? players
      : sortPlayers(players, sortConfig.key, sortConfig.direction);

    desktopTable.style.display = "table";
    emptyMessage.style.display = "none";

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
      const name =
        player.username === "@unknown"
          ? player.name
          : player.username.replace(/@/g, "");

      const desktopRow = `
        <tr class="player-row" data-player-index="${index}">
          <td data-label="№">${index + 1}</td>
          <td data-label="Игрок">
            <div class="player-info">
              <div class="player-photo"> 
                <img src="/img/players/${
                  player.photo
                }?v=1.1.2" alt="${name}" class="">
              </div>
              <span>${name}</span>
            </div>
          </td>
          <td data-label="Игры">${player.gamesPlayed}</td>
          <td data-label="Поб">${player.wins}</td>
          <td data-label="Нич">${player.draws}</td>
          <td data-label="Пор">${player.losses}</td>
          <td data-label="Голы">${player.goals}</td>
          <td data-label="Асс">${player.assists || 0}</td>
          <td data-label="Сейвы">${player.saves || 0}</td>
          <td data-label="MVP">${player.mvp || 0}</td>
          <td data-label="Рейт">${player.rating}</td>
        </tr>
      `;
      desktopTableBody.insertAdjacentHTML("beforeend", desktopRow);
    });

    document.querySelectorAll(".player-row").forEach((row) => {
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

  const showPlayerModal = (player, teamNameFromContext) => {
    const name =
      player.username === "@unknown"
        ? player.name
        : player.username.replace(/@/g, "");

    document.getElementById("modal-player-name").textContent = name;
    document.getElementById("modal-player-photo").src = `/img/players/${player.photo}?v=1.1.2`;
    document.getElementById("modal-player-photo").alt = name;

    const displayTeamName = teamNameFromContext || player.teamName;

    // Обновляем информацию о команде, если есть (в т.ч. при переходе из попапа команды)
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
          openTeamModalFromPlayer(displayTeamName);
        };
        teamInfo.style.cursor = "pointer";
      } else {
        teamInfo.style.display = "none";
        teamInfo.onclick = null;
        teamInfo.style.cursor = "default";
      }
    }
    
    // Обновляем значения для мобильных (Swiper)
    document.getElementById("modal-player-games").textContent = player.gamesPlayed;
    document.getElementById("modal-player-wins").textContent = player.wins;
    document.getElementById("modal-player-draws").textContent = player.draws;
    document.getElementById("modal-player-losses").textContent = player.losses;
    document.getElementById("modal-player-goals").textContent = player.goals;
    document.getElementById("modal-player-assists").textContent = player.assists || 0;
    document.getElementById("modal-player-saves").textContent = player.saves || 0;
    document.getElementById("modal-player-mvp").textContent = player.mvp || 0;
    
    // Обновляем значения для десктопа
    document.getElementById("modal-player-games-desktop").textContent = player.gamesPlayed;
    document.getElementById("modal-player-wins-desktop").textContent = player.wins;
    document.getElementById("modal-player-draws-desktop").textContent = player.draws;
    document.getElementById("modal-player-losses-desktop").textContent = player.losses;
    document.getElementById("modal-player-goals-desktop").textContent = player.goals;
    document.getElementById("modal-player-assists-desktop").textContent = player.assists || 0;
    document.getElementById("modal-player-saves-desktop").textContent = player.saves || 0;
    document.getElementById("modal-player-mvp-desktop").textContent = player.mvp || 0;
    
    document.getElementById("modal-player-rating").textContent = player.rating;
    
    // Инициализируем Swiper для статистики на мобильных
    const statsSwiperContainer = document.querySelector('.stats-swiper');
    if (statsSwiperContainer && window.innerWidth < 576 && typeof Swiper !== 'undefined') {
      // Удаляем старый Swiper, если есть
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

    playerModal.show();
  };

  // Функция для открытия попапа команды по названию
  const openTeamModalFromPlayer = async (teamName) => {
    try {
      // Закрываем попап игрока
      const playerModalElement = document.getElementById("playerModal");
      if (playerModalElement) {
        const playerModalInstance = bootstrap.Modal.getInstance(playerModalElement);
        if (playerModalInstance) {
          playerModalInstance.hide();
        }
      }

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
      
      // Формируем путь к фото команды
      const teamFileName = teamNameMap[team.name] || 
        team.name.toLowerCase()
          .replace(/\s+/g, '')
          .replace(/ё/g, 'e')
          .replace(/й/g, 'i') + '.webp';
      const teamPhotoPath = `/img/team/${teamFileName}`;

      // Открываем попап команды
      const teamModalElement = document.getElementById("teamModal");
      if (!teamModalElement) return;

      // Формируем данные игроков команды
      const teamPlayers = teamData.players ? teamData.players.map(p => ({
        name: p.name,
        username: p.username || null,
        photo: `/img/players/${p.photo}`,
        isCaptain: p.is_captain || false,
        isMainPlayer: p.is_main_player || false,
        icon: p.yellow_cards > 0 ? '🟨'.repeat(Math.min(p.yellow_cards, 2)) : ''
      })) : [];

      // Формируем строку трофеев
      const trophiesStr = team.trophies ? '🏆'.repeat(team.trophies) : '';

      // Заполняем данные попапа
      const modalName = document.getElementById("modal-team-name");
      const modalPhoto = document.getElementById("modal-team-photo");
      const modalTrophies = document.getElementById("modal-team-trophies");
      const modalPlayers = document.getElementById("modal-team-players");

      if (modalName) modalName.textContent = team.name;
      if (modalPhoto) {
        const fallbackTeamLogoPath = '/img/team/logo.jpg';
        modalPhoto.onerror = function () {
          modalPhoto.onerror = null;
          modalPhoto.src = fallbackTeamLogoPath;
        };
        modalPhoto.src = teamPhotoPath;
      }

      if (modalTrophies) {
        const trophyCount = team.trophies || 0;
        if (trophyCount >= 2) {
          modalTrophies.innerHTML = `<span class="trophy-count">${trophyCount}</span>`;
        } else {
          modalTrophies.textContent = trophiesStr;
        }
      }

      // Очищаем и заполняем игроков
      const swiperWrapper = modalPlayers?.querySelector('.swiper-wrapper');
      const gridDesktop = modalPlayers?.querySelector('.team-players-grid-desktop');
      
      if (swiperWrapper) swiperWrapper.innerHTML = "";
      if (gridDesktop) gridDesktop.innerHTML = "";

      if (teamPlayers && teamPlayers.length > 0) {
        // Сортируем игроков
        const sortedPlayers = [...teamPlayers].sort((a, b) => {
          if (a.isCaptain && !b.isCaptain) return -1;
          if (!a.isCaptain && b.isCaptain) return 1;
          if (a.isMainPlayer && !b.isMainPlayer) return -1;
          if (!a.isMainPlayer && b.isMainPlayer) return 1;
          return 0;
        });

        // Группируем для Swiper (по 5 игроков на слайд)
        const playersPerSlide = 5;
        let currentSlidePlayers = [];
        
        sortedPlayers.forEach((player, index) => {
          const captainClass = player.isCaptain ? ' is-captain' : '';
          const mainPlayerClass = player.isMainPlayer ? ' is-main-player' : '';
          
          // Формируем отображаемое имя так же, как в showPlayerModal
          const displayName = player.username === "@unknown" || !player.username
            ? player.name
            : player.username.replace(/@/g, "");
          
          // Экранируем имя и username для использования в data-атрибутах
          const playerNameEscaped = player.name.replace(/"/g, '&quot;');
          const playerUsernameEscaped = (player.username || '').replace(/"/g, '&quot;');
          const displayNameEscaped = displayName.replace(/"/g, '&quot;');
          const playerItem = `
            <div class="player-card${captainClass}${mainPlayerClass}" data-player-name="${playerNameEscaped}" data-player-username="${playerUsernameEscaped}" style="cursor: pointer;">
              <img src="${player.photo}" alt="${displayName}" class="player-photo">
              <div class="player-info">
                <span class="player-name">${displayName}${player.icon ? ' ' + player.icon : ''}</span>
              </div>
            </div>
          `;
          
          currentSlidePlayers.push(playerItem);
          
          if (currentSlidePlayers.length === playersPerSlide || index === sortedPlayers.length - 1) {
            if (swiperWrapper) {
              swiperWrapper.insertAdjacentHTML("beforeend", `
                <div class="swiper-slide">
                  <div class="team-players-slide-grid">
                    ${currentSlidePlayers.join('')}
                  </div>
                </div>
              `);
            }
            currentSlidePlayers = [];
          }
          
          if (gridDesktop) {
            gridDesktop.insertAdjacentHTML("beforeend", playerItem);
          }
        });

        // Добавляем обработчики клика на карточки игроков
        const allPlayerCards = modalPlayers.querySelectorAll('.player-card');
        allPlayerCards.forEach((card) => {
          card.addEventListener('click', (e) => {
            e.stopPropagation();
            const playerName = card.getAttribute('data-player-name');
            if (!playerName) return;

            // Ищем игрока в массиве players по имени
            const player = players.find(p => {
              const playerDisplayName = p.username === "@unknown" ? p.name : p.username.replace(/@/g, "");
              return playerDisplayName === playerName || p.name === playerName || p.username === playerName;
            });

            if (player) {
              const teamModalInstance = bootstrap.Modal.getInstance(teamModalElement);
              if (teamModalInstance) {
                teamModalInstance.hide();
              }
              showPlayerModal(player, team.name);
            }
          });
        });

        // Инициализируем Swiper
        const swiperContainer = modalPlayers?.querySelector('.team-players-swiper');
        if (swiperContainer && typeof Swiper !== 'undefined') {
          if (swiperContainer.swiper) {
            swiperContainer.swiper.destroy(true, true);
          }
          
          if (window.innerWidth < 576) {
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

              // Ищем игрока в массиве players по имени или username
              const player = players.find(p => {
                const playerDisplayName = p.username === "@unknown" ? p.name : p.username.replace(/@/g, "");
                // Сравниваем по отображаемому имени, имени или username
                if (playerDisplayName === playerName || p.name === playerName) return true;
                if (playerUsername && (p.username === playerUsername || p.username === `@${playerUsername}`)) return true;
                return false;
              });

              if (player) {
                const teamModalInstance = bootstrap.Modal.getInstance(teamModalElement);
                if (teamModalInstance) {
                  teamModalInstance.hide();
                }
                showPlayerModal(player, team.name);
              }
            });
          });
        }, 100);
      }

      // Открываем попап
      const teamModal = new bootstrap.Modal(teamModalElement);
      teamModal.show();

    } catch (error) {
      console.error("Ошибка при открытии попапа команды:", error);
    }
  };

  const fetchPlayers = async () => {
    loader.style.display = "block";
    errorMessage.style.display = "none";
    try {
      const controller = new AbortController();
      const timeoutId = setTimeout(() => controller.abort(), 5000);
      const response = await fetch(
        `https://football.pavelsolntsev.ru/api/players.php?t=${Date.now()}`,
        {
          cache: "no-store",
          signal: controller.signal,
        }
      );
      clearTimeout(timeoutId);
      if (!response.ok) {
        throw new Error(`Ошибка загрузки данных (статус: ${response.status})`);
      }
      const data = await response.json();
      players = data;
      localStorage.setItem(
        "players",
        JSON.stringify({ data, timestamp: Date.now() })
      );
      renderTable();
    } catch (error) {
      console.error("Ошибка в fetchPlayers:", error);
      errorMessage.textContent =
        error.name === "AbortError"
          ? "Превышен таймаут запроса"
          : error.message || "Ошибка сети";
      errorMessage.style.display = "block";
      const cachedPlayers = localStorage.getItem("players");
      if (cachedPlayers) {
        const { data, timestamp } = JSON.parse(cachedPlayers);
        const cacheAge = (Date.now() - timestamp) / 1000 / 60;
        if (cacheAge < 60) {
          players = data;
          renderTable();
        }
      }
      setTimeout(fetchPlayers, 1000);
    } finally {
      loader.style.display = "none";
    }
  };

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

  // Обработчик resize с debounce для обновления сокращения имен
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      if (players.length > 0) {
        renderTable();
      }
    }, 150); // Debounce 150ms
  });

  fetchPlayers();
});