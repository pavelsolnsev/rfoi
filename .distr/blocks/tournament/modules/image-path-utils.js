/**
 * Пути к WebP для фото игроков и логотипов команд (модули ES).
 */

/** Имя файла из БД / API -> .webp */
export function playerPhotoFileToWebp(filename) {
  if (!filename || typeof filename !== 'string') return 'default.webp';
  const base = filename.includes('/') ? filename.split('/').pop() : filename;
  if (/\.webp$/i.test(base)) return base;
  return base.replace(/\.(png|jpe?g)$/i, '.webp');
}

/** Относительный путь img/players/... для данных команды */
export function playerImgPlayersPath(filename) {
  const f = playerPhotoFileToWebp(filename);
  return `img/players/${f}`;
}

/** /img/players/... для атрибута src */
export function resolvePlayerPhotoSrc(photo) {
  if (!photo) return '/img/players/default.webp';
  let name = String(photo);
  if (name.includes('/')) name = name.split('/').pop();
  name = playerPhotoFileToWebp(name);
  return `/img/players/${name}`;
}

/** img/team/foo.png|jpg -> img/team/foo.webp */
export function teamRasterPathToWebp(imgPath) {
  if (!imgPath) return 'img/team/logo.webp';
  return imgPath.replace(/\.(png|jpe?g)(?=\?|$)/i, '.webp');
}

/**
 * Добавляет ?v=… из window.RFOI_IMAGES_V (default.php) — новый URL, браузер не отдаёт старый кэш.
 */
export function withImageCacheQuery(url) {
  if (!url || typeof url !== 'string') return url;
  const v =
    typeof window !== 'undefined' && window.RFOI_IMAGES_V != null
      ? String(window.RFOI_IMAGES_V)
      : '';
  if (v === '') return url;
  return `${url}${url.includes('?') ? '&' : '?'}v=${encodeURIComponent(v)}`;
}
