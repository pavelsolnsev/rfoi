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

const normalizeCandidateString = (value) => {
  if (value === null || value === undefined) return '';
  if (typeof value !== 'string') return String(value);
  return value;
};

export const isBlankString = (value) => {
  const str = normalizeCandidateString(value).trim();
  if (!str) return true;
  const lowered = str.toLowerCase();
  return lowered === 'null' || lowered === 'undefined' || lowered === 'nan';
};

export const normalizeUsername = (username) => {
  const str = normalizeCandidateString(username).trim();
  if (!str) return '';
  return str.replace(/@/g, '').trim();
};

export const getPlayerDisplayName = (player, fallback = 'Неизвестно') => {
  const usernameRaw = player?.username;
  const usernameNormalized = normalizeUsername(usernameRaw);
  const usernameIsUnknown = normalizeCandidateString(usernameRaw).trim().toLowerCase() === '@unknown';

  if (!usernameIsUnknown && !isBlankString(usernameNormalized)) {
    return usernameNormalized;
  }

  const name = normalizeCandidateString(player?.name).trim();
  if (!isBlankString(name)) return name;

  return fallback;
};

