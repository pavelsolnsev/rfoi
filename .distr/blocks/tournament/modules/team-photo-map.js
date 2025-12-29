/**
 * Модуль для работы с фото команд
 * Содержит маппинг названий команд на пути к фото
 */

// Маппинг названий команд на пути к фото
export const teamPhotoMap = {
  'РФОИ': 'img/team/admin.png',
  'Леон': 'img/team/leon.webp',
  'Ручеёк': 'img/team/rych.webp',
  'Worlds': 'img/team/worlds.png',
  'volt': 'img/team/volt.webp',
  'UN': 'img/team/un.webp',
  'California': 'img/team/california.webp',
  'Engelbert': 'img/team/Engelbert.png',
  'Ясность': 'img/team/iasnostb.jpg',
};

/**
 * Функция формирования пути к фото команды
 * @param {string} teamName - Название команды
 * @returns {string} Путь к фото команды
 */
export const getTeamPhotoPath = (teamName) => {
  // Проверяем маппинг
  if (teamPhotoMap[teamName]) {
    return teamPhotoMap[teamName];
  }
  
  // Если команды нет в маппинге, возвращаем дефолтное изображение
  return 'img/team/logo.jpg';
};

