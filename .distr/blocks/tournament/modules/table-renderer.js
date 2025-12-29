/**
 * Модуль для рендеринга таблицы команд
 */

import { sortTeams, updateSortIndicators } from './table-sorter.js';
import { openTeamModal } from './modal-handler.js';

/**
 * Рендеринг таблицы команд
 * @param {HTMLElement} teamsTableBody - Элемент tbody таблицы
 * @param {HTMLElement} teamsTable - Элемент таблицы
 * @param {Array} teams - Массив команд
 * @param {Object} sortConfig - Конфигурация сортировки {key, direction}
 */
export const renderTeamsTable = (teamsTableBody, teamsTable, teams, sortConfig) => {
  teamsTableBody?.replaceChildren();
  const sortedTeams = sortTeams(teams, sortConfig.key, sortConfig.direction);

  sortedTeams.forEach((team, index) => {
    const row = `
      <tr class="team-row" data-team-index="${index}">
        <td data-label="№">${index + 1}</td>
        <td data-label="Команда">
          <div class="player-info">
            <div class="player-photo">
              <img src="${team.photo}" alt="${team.name}" onerror="this.src='img/team/logo.jpg'">
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

  updateSortIndicators(teamsTable, sortConfig);
  
  // Анимация появления строк таблицы с задержкой
  setTimeout(() => {
    const rows = teamsTableBody.querySelectorAll(".team-row");
    rows.forEach((row, index) => {
      setTimeout(() => {
        row.classList.add("animate-in");
      }, index * 30); // Задержка 30 мс между строками
    });
  }, 100);
};

