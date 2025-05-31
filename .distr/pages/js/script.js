$(function () {
  window.addEventListener("resize", () => {
    renderTable();
  });

  const desktopTable = document.getElementById("desktop-table");
  const desktopTableBody = document.getElementById("desktop-table-body");
  const errorMessage = document.getElementById("error-message");
  const emptyMessage = document.getElementById("empty-message");
  const loader = document.getElementById("loader");

  if (
    !desktopTable ||
    !desktopTableBody ||
    !errorMessage ||
    !emptyMessage ||
    !loader
  ) {
    console.error("Ошибка: Один или несколько элементов DOM не найдены");
    return;
  }

  let players = [];

  const getMaxNameLength = () => (window.innerWidth <= 992 ? 20 : 30);

  const renderTable = () => {
    desktopTableBody.innerHTML = "";
    const sortedPlayers = [...players].sort((a, b) => b.rating - a.rating);
    const maxNameLength = getMaxNameLength();

    sortedPlayers.forEach((player, index) => {
      let name =
        player.username === "@unknown"
          ? player.name
          : player.username.replace(/@/g, "");
      if (name.length > maxNameLength) {
        name = name.substring(0, maxNameLength) + "...";
      }

      const desktopRow = `
  <tr>
    <td data-label="№">${index + 1}</td>
    <td data-label="Игрок">
      <div class="player-info">
        <div class="player-photo"> 
          <img src="/img/players/${
            player.photo
          }?v=1.0.1" alt="${name}" class="">
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

    desktopTable.style.display = "table";
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
      // Добавляем искусственную задержку в 3 секунды
      // await new Promise((resolve) => setTimeout(resolve, 3000));
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
        const cacheAge = (Date.now() - timestamp) / 1000 / 60; // В минутах
        if (cacheAge < 60) {
          // Использовать кэш, если он не старше 60 минут
          players = data;
          renderTable();
        }
      }
      setTimeout(fetchPlayers, 1000);
    } finally {
      loader.style.display = "none";
    }
  };

  // const cachedPlayers = localStorage.getItem("players");
  // if (cachedPlayers) {
  //   const { data, timestamp } = JSON.parse(cachedPlayers);
  //   const cacheAge = (Date.now() - timestamp) / 1000 / 60; // В минутах
  //   if (cacheAge < 60) {
  //     players = data;
  //     renderTable();
  //   } else {
  //     localStorage.removeItem("players"); // Удалить устаревший кэш
  //   }
  // }
  fetchPlayers();
});
