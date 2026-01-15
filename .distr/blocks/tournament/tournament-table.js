/**
 * Основной модуль для управления турнирной таблицей команд
 * Отображает таблицу команд, сортировку и модальные окна
 */

import { loadTeamsData } from './modules/api-loader.js';
import { renderTeamsTable } from './modules/table-renderer.js';

document.addEventListener("DOMContentLoaded", () => {
  const teamsTable = document.getElementById("teams-table");
  const teamsTableBody = document.getElementById("teams-table-body");
  
  if (!teamsTable || !teamsTableBody) {
    return; // Элементы таблицы не найдены, выходим
  }

  let teams = [];
  let teamsSortConfig = {
    key: "points",
    direction: "desc",
  };

  // Функция загрузки данных и рендеринга таблицы
  const loadAndRender = async () => {
    try {
      teams = await loadTeamsData(() => {
        renderTeamsTable(teamsTableBody, teamsTable, teams, teamsSortConfig);
      }, teamsTableBody);
      
      renderTeamsTable(teamsTableBody, teamsTable, teams, teamsSortConfig);
    } catch (error) {
      // Ошибка уже обработана в loadTeamsData
    }
  };

  // Сортировка по заголовкам
  teamsTable.querySelectorAll("th").forEach((th) => {
    const sortKey = th.getAttribute("data-sort");

    // Игнорируем игры
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
      renderTeamsTable(teamsTableBody, teamsTable, teams, teamsSortConfig);
    });
  });

  // Обработчик resize с debounce для обновления отображения названий команд
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      if (teams.length > 0) {
        renderTeamsTable(teamsTableBody, teamsTable, teams, teamsSortConfig);
      }
    }, 150); // Debounce 150ms
  });

  // Загружаем данные при загрузке страницы
  loadAndRender();
});
