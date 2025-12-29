/**
 * Модуль для загрузки данных из API
 */

import { getTeamPhotoPath } from './team-photo-map.js';
import { formatTrophies } from './format-utils.js';

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

    // Логируем данные для отладки
    console.log('DEBUG: Данные игроков из API:', playersData);
    playersData.forEach(teamGroup => {
      const pavelsRecords = teamGroup.players.filter(p => p.name === 'Павел Солнцев' || p.player_id === 312571900);
      if (pavelsRecords.length > 0) {
        console.log(`DEBUG: Павел Солнцев найден в команде ${teamGroup.team_id} (${teamGroup.team_name}):`, pavelsRecords);
      }
    });

    // Создаем карту игроков по team_name (а не team_id)
    // Это важно, так как team_id может не совпадать с team_name
    const playersByTeam = {};
    playersData.forEach(teamGroup => {
      // Используем team_name как ключ для группировки
      const teamNameKey = teamGroup.team_name.toLowerCase();
      playersByTeam[teamNameKey] = teamGroup.players.map(player => ({
        name: player.name || player.username || '',
        photo: player.photo ? `img/players/${player.photo}` : 'img/players/default.jpg',
        isCaptain: player.is_captain || false
      }));
    });
    
    console.log('DEBUG: Карта игроков по командам:', playersByTeam);

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

