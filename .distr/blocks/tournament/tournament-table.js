/**
 * Модуль для управления турнирной таблицей команд
 * Отображает таблицу команд, сортировку и модальные окна
 */

//=require tournament/teams-data.js

document.addEventListener("DOMContentLoaded", () => {
  const teamsTable = document.getElementById("teams-table");
  const teamsTableBody = document.getElementById("teams-table-body");
  
  if (!teamsTable || !teamsTableBody) {
    return; // Элементы таблицы не найдены, выходим
  }

  let teams = [...TEAMS_DATA]; // Используем данные из отдельного файла
  let teamsSortConfig = {
    key: "points",
    direction: "desc",
  };

  // Функция сортировки команд
  const sortTeams = (teams, key, direction) => {
    return [...teams].sort((a, b) => {
      let valueA = a[key];
      let valueB = b[key];

      if (key === "name") {
        return direction === "asc"
          ? valueA.localeCompare(valueB)
          : valueB.localeCompare(valueA);
      }
      return direction === "asc" ? valueA - valueB : valueB - valueA;
    });
  };

  // Обновление индикаторов сортировки
  const updateSortIndicators = () => {
    // Сброс стрелочек
    document.querySelectorAll("#teams-table th span").forEach((span) => {
      span.textContent = span.textContent.replace(/[▲▼]/g, "").trim();
    });

    // Установка стрелочек
    document.querySelectorAll("#teams-table th").forEach((th) => {
      const sortKey = th.getAttribute("data-sort");

      if (sortKey && !["index", "name", "games"].includes(sortKey)) {
        const spans = th.querySelectorAll("span");
        const isActive = sortKey === teamsSortConfig.key;
        const indicator = isActive
          ? teamsSortConfig.direction === "asc"
            ? " ▲"
            : " ▼"
          : " ▼";
        spans.forEach((span) => {
          span.textContent += indicator;
        });
      }
    });

    // Добавляем класс к таблице
    if (teamsTable) {
      teamsTable.classList.remove("table-asc", "table-desc");
      teamsTable.classList.add(
        teamsSortConfig.direction === "asc" ? "table-asc" : "table-desc"
      );
    }
  };

  // Функция открытия модала команды
  const openTeamModal = (team) => {
    const modalName = document.getElementById("modal-team-name");
    const modalPhoto = document.getElementById("modal-team-photo");
    const modalPlayers = document.getElementById("modal-team-players");
    const modalTrophies = document.getElementById("modal-team-trophies");

    if (!modalName || !modalPhoto || !modalPlayers || !modalTrophies) {
      return; // Элементы модального окна не найдены
    }

    modalName.textContent = team.name;
    modalTrophies.textContent = team.trophies;
    modalPhoto.src = team.photo;
    modalPlayers.innerHTML = "";

    team.players.forEach((player) => {
      const playerItem = `
        <div class="player-card">
          <img src="${player.photo}" alt="${player.name}" class="player-photo">
          <div class="player-info">
            <span class="player-name">${player.name}${player.icon ? ' ' + player.icon : ''}</span>
          </div>
        </div>
      `;
      modalPlayers.insertAdjacentHTML("beforeend", playerItem);
    });

    const teamModalElement = document.getElementById("teamModal");
    if (teamModalElement && typeof bootstrap !== 'undefined') {
      const teamModal = new bootstrap.Modal(teamModalElement);
      teamModal.show();
    }
  };

  // Рендеринг таблицы
  const renderTeamsTable = () => {
    teamsTableBody?.replaceChildren();
    const sortedTeams = sortTeams(
      teams,
      teamsSortConfig.key,
      teamsSortConfig.direction
    );

    sortedTeams.forEach((team, index) => {
      const row = `
        <tr class="team-row" data-team-index="${index}">
          <td data-label="№">${index + 1}</td>
          <td data-label="Команда">
            <div class="player-info">
              <div class="player-photo">
                <img src="${team.photo}" alt="${team.name}">
              </div>
              <span>${team.name}</span>
            </div>
          </td>
          <td data-label="Трофеи">${team.trophies}</td>
          <td data-label="Победы">${team.tournaments}</td>
          <td data-label="Очки">${team.points}</td>
        </tr>
      `;
      teamsTableBody?.insertAdjacentHTML("beforeend", row);
    });

    // Навешиваем клик на строки
    document.querySelectorAll(".team-row").forEach((row) => {
      row.addEventListener("click", () => {
        const teamIndex = row.getAttribute("data-team-index");
        openTeamModal(sortedTeams[teamIndex]);
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

  // Сортировка по заголовкам
  teamsTable.querySelectorAll("th").forEach((th) => {
    const sortKey = th.getAttribute("data-sort");

    // Игнорируем games
    if (!sortKey || sortKey === "games") return;

    th.style.cursor = "pointer";
    th.addEventListener("click", () => {
      if (teamsSortConfig.key === sortKey) {
        teamsSortConfig.direction =
          teamsSortConfig.direction === "asc" ? "desc" : "asc";
      } else {
        teamsSortConfig.key = sortKey;
        teamsSortConfig.direction = "asc";
      }
      renderTeamsTable();
    });
  });

  renderTeamsTable();
});

