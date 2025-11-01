document.addEventListener("DOMContentLoaded", () => {
  const teamsTable = document.getElementById("teams-table");
  const teamsTableBody = document.getElementById("teams-table-body");
  let teams = [];
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

    // ---- Добавляем класс к таблице ----
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

    modalName.textContent = team.name;
    modalTrophies.textContent = team.trophies;
    modalPhoto.src = team.photo;
    modalPlayers.innerHTML = "";

    team.players.forEach((player) => {
      const playerItem = `
                <div class="player-card">
                    <img src="${player.photo}" alt="${player.name}" class="player-photo">
                    <div class="player-info">
                        <span class="player-name">${player.name}</span>
                    </div>
                </div>
            `;
      modalPlayers.insertAdjacentHTML("beforeend", playerItem);
    });

    const teamModal = new bootstrap.Modal(document.getElementById("teamModal"));
    teamModal.show();
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
  };

  // Сортировка по заголовкам
  if (teamsTable) {
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
  }

  teams = [
    {
      name: "Администрация",
      trophies: "🏆🏆",
      tournaments: 2,
      points: 6,
      photo: "img/team/admin2.webp",
      players: [
        {
          name: "pavelsolnsev",
          photo: "img/players/pavelsolnsev.png",
        },
        {
          name: "Gavrilovram",
          photo: "img/players/Gavrilov.png",
        },
        {
          name: "delay_kpacubo",
          photo: "img/players/kpacubo.png",
        },
        {
          name: "Perunov_Vladislav",
          photo: "img/players/Perunov_Vladislav.png",
        },
        {
          name: "dergaev94",
          photo: "img/players/dergaev.png",
        },
      ],
    },
    {
      name: "Леон",
      trophies: "⚪️",
      tournaments: 3,
      points: 4,
      photo: "img/team/leon.webp",
      players: [
        {
          name: "nikita_a1exandrovich",
          photo: "img/players/nikita.png",
        },
        {
          name: "Vadik_69_11",
          photo: "img/players/Vadik.png",
        },
        {
          name: "al11114",
          photo: "img/players/al11114.png",
        },
        {
          name: "toxa1392777",
          photo: "img/players/toxa1392777.png",
        },
        {
          name: "toshnotik666",
          photo: "img/players/toshnotik666.png",
        },
        {
          name: "vehrbrvk50",
          photo: "img/players/default.jpg",
        },
        {
          name: "alexdugar59",
          photo: "img/players/alexdugar59.png",
        },
        {
          name: "TimRamen",
          photo: "img/players/TimRamen.png",
        },
      ],
    },
    {
      name: "Ручеёк",
      trophies: "🏆",
      tournaments: 2,
      points: 3,
      photo: "img/team/nologo.webp",
      players: [
        {
          name: "Ислам Халиков",
          photo: "img/players/islam.png",
        },
        {
          name: "seivrtd",
          photo: "img/players/seivrtd.png",
        },
        {
          name: "Mirinian",
          photo: "img/players/mirinian.png",
        },
        {
          name: "AlexeiD2025",
          photo: "img/players/AlexeiD2025.png",
        },
        {
          name: "svyatoslavspirin",
          photo: "img/players/svyatoslavspirin.png",
        },
      ],
    },
    {
      name: "Брано",
      trophies: "⚪️",
      tournaments: 1,
      points: 2,
      photo: "img/team/nologo.webp",
      players: [
        {
          name: "filipps1",
          photo: "img/players/filipps1.png",
        },
        {
          name: "vl_l24",
          photo: "img/players/vl_l24.png",
        },
        {
          name: "Mirinian",
          photo: "img/players/mirinian.png",
        },
        {
          name: "SenyaAvgan",
          photo: "img/players/senyaAvgan.png",
        },
        {
          name: "mr_snak4",
          photo: "img/players/mr_snak4.png",
        },
      ],
    },
    {
      name: "Worlds",
      trophies: "⚪️",
      tournaments: 2,
      points: 2,
      photo: "img/team/nologo.webp",
      players: [
        {
          name: "Jorik",
          photo: "img/players/jorik.png",
        },
        {
          name: "evgeniyshvetsov",
          photo: "img/players/evgeniyshvetsov.png",
        },
        {
          name: "Дмитрий З",
          photo: "img/players/default.jpg",
        },
        {
          name: "ZhekaFootball",
          photo: "img/players/Evgenkozl.png",
        },
        {
          name: "Александр",
          photo: "img/players/aleksandr.png",
        },
        {
          name: "Даниил Турланов",
          photo: "img/players/tyrlanov.png",
        },
        {
          name: "Vyacheslav Batrakov",
          photo: "img/players/vacheslav.png",
        },
      ],
    },
    {
      name: "Вольт",
      trophies: "⚪️",
      tournaments: 1,
      points: 1,
      photo: "img/team/nologo.webp",
      players: [
        {
          name: "t1ma27",
          photo: "img/players/t1ma27.png",
        },
        {
          name: "y0ung_m0on",
          photo: "img/players/igor_oru.png",
        },
        {
          name: "Abdulatip44",
          photo: "img/players/Abdulatip44.png",
        },
        {
          name: "KroxaAn",
          photo: "img/players/kroxaAn.png",
        },
        {
          name: "deltaivan",
          photo: "img/players/deltaivan.png",
        },
      ],
    },
    {
      name: "Юность",
      trophies: "⚪️",
      tournaments: 1,
      points: 0,
      photo: "img/team/nologo.webp",
      players: [
        {
          name: "deltaivan",
          photo: "img/players/deltaivan.png",
        },
        {
          name: "Aleksey_AS_NR",
          photo: "img/players/Aleksey_AS_NR.png",
        },
        {
          name: "KroxaAn",
          photo: "img/players/kroxaAn.png",
        },
        {
          name: "Дмитрий Шмелев",
          photo: "img/players/shmel.png",
        },

        {
          name: "Vyacheslav Batrakov",
          photo: "img/players/vacheslav.png",
        },
      ],
    },
    {
      name: "Engelbert",
      trophies: "⚪️",
      tournaments: 0,
      points: 0,
      photo: "img/team/nologo.webp",
      players: [
        {
          name: "AlyevRuslan",
          photo: "img/players/CyJlTaH1117.png",
        },
        {
          name: "izi0895",
          photo: "img/players/izi0895.png",
        },
        {
          name: " IIpets",
          photo: "img/players/IIpets.png",
        },
        {
          name: "HA_3AKATE_KAPbEPbI",
          photo: "img/players/default.jpg",
        },

        {
          name: "GoshaSc",
          photo: "img/players/default.jpg",
        },
      ],
    },
  ];

  renderTeamsTable();
});
