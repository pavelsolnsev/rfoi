/**
 * Модуль для работы с фото команд
 * Содержит маппинг названий команд на пути к фото
 */

// Маппинг названий команд на пути к фото
export const teamPhotoMap = {
  'РФОИ': 'img/team/admin.webp',
  'Леон': 'img/team/leon.webp',
  'Ручеёк': 'img/team/rych.webp',
  'Worlds': 'img/team/worlds.webp',
  'Volt': 'img/team/volt.webp',
  'Юность': 'img/team/un.webp',
  'California': 'img/team/california.webp',
  'Юность': 'img/team/un.webp',
  'Engelbert': 'img/team/Engelbert.webp',
  'Ясность': 'img/team/iasnostb.webp',
  'Анжи': 'img/team/anji.webp',
  'Артемида': 'img/team/artemida.webp',
  'Титан': 'img/team/titan.webp',
  'FC Chelsea': 'img/team/\u0441helsea.webp',
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
  return 'img/team/logo.webp';
};

