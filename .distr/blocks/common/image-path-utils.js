/**
 * Единые правила путей к WebP для фото игроков (подключается через gulp-include).
 */
function playerPhotoFileToWebp(filename) {
  if (!filename || typeof filename !== 'string') return 'default.webp';
  var base = filename.indexOf('/') >= 0 ? filename.split('/').pop() : filename;
  if (/\.webp$/i.test(base)) return base;
  return base.replace(/\.(png|jpe?g)$/i, '.webp');
}

/** Полный путь /img/players/... для src */
function resolvePlayerPhotoSrc(photo) {
  if (!photo) return '/img/players/default.webp';
  var name = String(photo);
  if (name.indexOf('/') >= 0) name = name.split('/').pop();
  name = playerPhotoFileToWebp(name);
  return '/img/players/' + name;
}
