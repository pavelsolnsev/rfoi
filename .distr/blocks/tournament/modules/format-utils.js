/**
 * Модуль утилит для форматирования данных
 */

/**
 * Функция преобразования количества трофеев в эмодзи
 * @param {number} count - Количество трофеев
 * @returns {string} Строка с эмодзи трофеев или белый круг
 */
export const formatTrophies = (count) => {
  if (!count || count === 0) {
    return '⚪️';
  }
  return '🏆'.repeat(count);
};

/**
 * Функция сокращения Unicode строки с учетом реальной длины символов
 * @param {string} str - Исходная строка
 * @param {number} maxLength - Максимальная длина
 * @returns {string} Сокращенная строка
 */
export const truncateUnicodeString = (str, maxLength) => {
  const chars = [...str];
  if (chars.length > maxLength) {
    return chars.slice(0, maxLength).join('') + '...';
  }
  return str;
};

/**
 * Функция получения максимальной длины названия команды в зависимости от ширины экрана
 * @returns {number} Максимальная длина названия
 */
export const getMaxTeamNameLength = () => {
  const width = window.innerWidth;
  const minWidth = 400;
  const maxWidth = 1200;
  const minLength = 8;
  const maxLength = 25;

  if (width <= minWidth) {
    return minLength;
  }

  if (width >= maxWidth) {
    return maxLength;
  }

  const ratio = (width - minWidth) / (maxWidth - minWidth);
  const length = minLength + (maxLength - minLength) * ratio;

  // Округляем до целого числа
  return Math.round(length);
};

