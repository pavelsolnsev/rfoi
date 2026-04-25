/**
 * Модуль для рендеринга таблицы команд
 */

import { sortTeams, updateSortIndicators } from './table-sorter.js';
import { openTeamModal } from './modal-handler.js';
import { withImageCacheQuery } from './image-path-utils.js';

/**
 * Рендеринг таблицы команд
 * @param {HTMLElement} teamsTableBody - Элемент tbody таблицы
 * @param {HTMLElement} teamsTable - Элемент таблицы
 * @param {Array} teams - Массив команд
 * @param {Object} sortConfig - Конфигурация сортировки {key, direction}
 */
export const renderTeamsTable = (teamsTableBody, teamsTable, teams, sortConfig) => {
  if (teamsTableBody) {
    teamsTableBody.innerHTML = "";
  }
  const sortedTeams = sortTeams(teams, sortConfig.key, sortConfig.direction);

  // Проверка на пустой список команд
  if (sortedTeams.length === 0) {
    const columnCount = teamsTable.querySelectorAll('thead th').length;
    const emptyRow = `
      <tr class="empty-row">
        <td colspan="${columnCount}" style="text-align: center; padding: 2rem;">
          <i class="fas fa-exclamation-circle"></i>
          <span style="margin-left: 0.5rem;">Список команд пуст</span>
        </td>
      </tr>
    `;
    teamsTableBody?.insertAdjacentHTML("beforeend", emptyRow);
    updateSortIndicators(teamsTable, sortConfig);
    return;
  }

  sortedTeams.forEach((team, index) => {
    // Форматируем трофеи: если больше 4, показываем число и одну иконку
    let trophiesDisplay = team.trophies || '';
    const trophyCount = (trophiesDisplay.match(/🏆/g) || []).length;
    if (trophyCount >= 2) {
      trophiesDisplay = `<span class="trophy-count"><span class="trophy-count-num">${trophyCount}</span></span>`;
    }
    
    const row = `
      <tr class="team-row" data-team-index="${index}">
        <td data-label="№">${index + 1}</td>
        <td data-label="Команда">
          <div class="player-info">
            <div class="player-photo">
              <img src="${withImageCacheQuery(team.photo)}" alt="${team.name}" loading="lazy" decoding="async" onerror="this.src='img/team/logo.webp'">
            </div>
            <span>${team.name}</span>
          </div>
        </td>
        <td data-label="Тр">${trophiesDisplay}</td>
        <td data-label="Тур">${team.tournaments}</td>
        <td data-label="Поб">${team.wins}</td>
        <td data-label="Нич">${team.draws}</td>
        <td data-label="Пор">${team.losses}</td>
        <td data-label="ЗМ">${team.goalsScored}</td>
        <td data-label="ПМ" class="goals-conceded-col">${team.goalsConceded}</td>
        <td data-label="РМ" class="goal-difference-col">${team.goalDifference}</td>
        <td data-label="О">${team.points}</td>
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

