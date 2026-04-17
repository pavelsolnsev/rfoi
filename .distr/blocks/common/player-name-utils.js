/**
 * Отображаемое имя игрока (логика синхронизирована с tournament/modules/format-utils.js#getPlayerDisplayName).
 * Подключается в legacy-бандлы через gulp-include (//=require common/player-name-utils.js).
 */
function normalizeCandidateString(value) {
  if (value === null || value === undefined) return '';
  if (typeof value !== 'string') return String(value);
  return value;
}

function isBlankString(value) {
  const str = normalizeCandidateString(value).trim();
  if (!str) return true;
  const lowered = str.toLowerCase();
  return lowered === 'null' || lowered === 'undefined' || lowered === 'nan';
}

function normalizeUsername(username) {
  const str = normalizeCandidateString(username).trim();
  if (!str) return '';
  return str.replace(/@/g, '').trim();
}

function getPlayerDisplayName(player, fallback) {
  if (fallback === undefined) fallback = 'Неизвестно';
  const usernameRaw = player && player.username;
  const usernameNormalized = normalizeUsername(usernameRaw);
  const usernameIsUnknown =
    normalizeCandidateString(usernameRaw).trim().toLowerCase() === '@unknown';

  if (!usernameIsUnknown && !isBlankString(usernameNormalized)) {
    return usernameNormalized;
  }

  const name = normalizeCandidateString(player && player.name).trim();
  if (!isBlankString(name)) return name;

  return fallback;
}
