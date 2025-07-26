$(function () {
  window.addEventListener("resize", () => {
    renderTable();
  });

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
    console.error("Ошибка: Один или несколько элементов DOM не найдены");
    return;
  }

  let players = [];
  let sortConfig = {
    key: 'rating',
    direction: 'desc'
  };

  const getMaxNameLength = () => (window.innerWidth <= 992 ? 20 : 30);

  const truncateUnicodeString = (str, maxLength) => {
    const chars = [...str];
    if (chars.length > maxLength) {
      return chars.slice(0, maxLength).join('') + '...';
    }
    return str;
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
    const sortedPlayers = sortPlayers(players, sortConfig.key, sortConfig.direction);
    const maxNameLength = getMaxNameLength();

    desktopTable.classList.toggle('table-asc', sortConfig.direction === 'asc');

    sortedPlayers.forEach((player, index) => {
      let name =
        player.username === "@unknown"
          ? player.name
          : player.username.replace(/@/g, "");
      name = truncateUnicodeString(name, maxNameLength);

      const desktopRow = `
        <tr class="player-row" data-player-index="${index}">
          <td data-label="№">${index + 1}</td>
          <td data-label="Игрок">
            <div class="player-info">
              <div class="player-photo"> 
                <img src="/img/players/${
                  player.photo
                }?v=1.0.3" alt="${name}" class="">
              </div>
              <span>${name}</span>
            </div>
          </td>
          <td data-label="Игры">${player.gamesPlayed}</td>
          <td data-label="Победы">${player.wins}</td>
          <td data-label="Ничьи">${player.draws}</td>
          <td data-label="Поражения">${player.losses}</td>
          <td data-label="Голы">${player.goals}</td>
          <td data-label="Рейтинг">${player.rating}</td>
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

    desktopTable.style.display = "table";
    updateSortIndicators();
  };

  const showPlayerModal = (player) => {
    let name =
      player.username === "@unknown"
        ? player.name
        : player.username.replace(/@/g, "");
    name = truncateUnicodeString(name, 30);

    document.getElementById("modal-player-name").textContent = name;
    document.getElementById("modal-player-photo").src = `/img/players/${player.photo}?v=1.0.3`;
    document.getElementById("modal-player-photo").alt = name;
    document.getElementById("modal-player-games").textContent = player.gamesPlayed;
    document.getElementById("modal-player-wins").textContent = player.wins;
    document.getElementById("modal-player-draws").textContent = player.draws;
    document.getElementById("modal-player-losses").textContent = player.losses;
    document.getElementById("modal-player-goals").textContent = player.goals;
    document.getElementById("modal-player-rating").textContent = player.rating;

    playerModal.show();
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
      console.log("Ответ получен, статус:", response.status);
      if (!response.ok) {
        throw new Error(`Ошибка загрузки данных (статус: ${response.status})`);
      }
      const data = await response.json();
      console.log("Данные успешно распарсены:", data);
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

  fetchPlayers();
});