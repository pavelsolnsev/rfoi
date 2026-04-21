/**
 * Модуль для загрузки данных из API
 */

import { getTeamPhotoPath } from './team-photo-map.js';
import { formatTrophies } from './format-utils.js';
import { playerImgPlayersPath } from './image-path-utils.js';

/**
 * Преобразует количество желтых карточек в строку с иконками
 * @param {number} count - количество желтых карточек
 * @returns {string} строка с иконками карточек или пустая строка
 */
const formatYellowCards = (count) => {
  if (!count || count <= 0) return '';
  return '🟨'.repeat(count);
};

const API_BASE_URL = 'https://football.pavelsolntsev.ru/api';

/**
 * Загружает данные команд и игроков из API
 * @param {Function} renderCallback - Функция для рендеринга таблицы после загрузки
 * @param {HTMLElement} teamsTableBody - Элемент tbody для отображения ошибок
 * @returns {Promise<Array>} Массив команд с данными
 */
export const loadTeamsData = async (renderCallback, teamsTableBody) => {
  try {
    // Загружаем команды
    const teamsUrl = `${API_BASE_URL}/teams.php?t=${Date.now()}`;
    const teamsResponse = await fetch(teamsUrl, {
      cache: "no-store"
    });
    
    if (!teamsResponse.ok) {
      const errorText = await teamsResponse.text();
      console.error('Ошибка загрузки команд:', teamsResponse.status, errorText);
      throw new Error(`Ошибка загрузки данных команд: ${teamsResponse.status} ${teamsResponse.statusText}`);
    }
    
    const teamsData = await teamsResponse.json();
    
    if (!Array.isArray(teamsData)) {
      console.error('Неверный формат данных команд:', teamsData);
      throw new Error('Неверный формат данных команд');
    }

    // Загружаем игроков команд
    const playersUrl = `${API_BASE_URL}/team_players.php?t=${Date.now()}`;
    const playersResponse = await fetch(playersUrl, {
      cache: "no-store"
    });
    
    if (!playersResponse.ok) {
      const errorText = await playersResponse.text();
      console.error('Ошибка загрузки игроков:', playersResponse.status, errorText);
      throw new Error(`Ошибка загрузки данных игроков: ${playersResponse.status} ${playersResponse.statusText}`);
    }
    
    const playersData = await playersResponse.json();

    // Создаем карту игроков по team_name (а не team_id)
    // Это важно, так как team_id может не совпадать с team_name
    const playersByTeam = {};
    playersData.forEach(teamGroup => {
      // Используем team_name как ключ для группировки
      const teamNameKey = teamGroup.team_name.toLowerCase();
      playersByTeam[teamNameKey] = teamGroup.players.map(player => ({
        name: player.name || '', // Оригинальное имя из базы
        username: player.username || null, // Username для правильного отображения
        photo: player.photo ? playerImgPlayersPath(player.photo) : 'img/players/default.webp',
        isCaptain: player.is_captain || false,
        isMainPlayer: player.is_main_player || false,
        yellowCards: player.yellow_cards || 0,
        icon: formatYellowCards(player.yellow_cards || 0)
      }));
    });

    // Преобразуем данные в нужный формат
    const teams = teamsData.map(team => {
      // Ищем игроков по названию команды (без учета регистра)
      const teamNameKey = team.name.toLowerCase();
      return {
        id: team.id,
        name: team.name,
        trophies: formatTrophies(team.trophies || 0),
        tournaments: team.tournament_count || 0,
        points: team.points || 0,
        wins: team.wins || 0,
        draws: team.draws || 0,
        losses: team.losses || 0,
        goalsScored: team.goals_scored || 0,
        goalsConceded: team.goals_conceded || 0,
        goalDifference: team.goal_difference || 0,
        photo: getTeamPhotoPath(team.name),
        players: playersByTeam[teamNameKey] || []
      };
    });

    return teams;
  } catch (error) {
    console.error('Ошибка загрузки данных:', error);
    console.error('Детали ошибки:', {
      message: error.message,
      stack: error.stack
    });
    
    if (teamsTableBody) {
      teamsTableBody.innerHTML = `
        <tr>
          <td colspan="5" style="text-align: center; padding: 2rem;">
            <i class="fas fa-exclamation-circle"></i>
            <span style="margin-left: 0.5rem;">Ошибка загрузки данных: ${error.message}</span>
          </td>
        </tr>
      `;
    }
    
    throw error;
  }
};

