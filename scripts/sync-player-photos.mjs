/**
 * Автосопоставление фото игроков с базой.
 *
 * Берёт .webp файлы из .distr/blocks/players/img, подбирает игрока по транслитерации
 * имени/фамилии и, если совпадение однозначное, прописывает photo в таблице players.
 *
 * Правила безопасности (см. обсуждение с пользователем):
 * - по умолчанию трогаем ТОЛЬКО новые файлы — те, что ещё не закоммичены в git
 *   (227 старых фото, которые уже лежали в репозитории, никогда не попадают в обработку,
 *   даже если для них находится уверенное совпадение — их разбирают отдельно, вручную)
 * - из новых файлов трогаем только игроков, у которых фото ещё не задано (null/''/default.*)
 * - если совпадений несколько или совпадение слабое — файл пропускается и попадает в отчёт,
 *   запись в базу не делается
 *
 * Креды берём напрямую из .distr/pages/api/players.php, чтобы не держать пароль в двух местах.
 *
 * Запуск:
 *   node scripts/sync-player-photos.mjs                         — только отчёт по новым файлам, в базу не пишет
 *   node scripts/sync-player-photos.mjs --apply                  — обновляет photo у новых файлов с однозначным совпадением
 *   node scripts/sync-player-photos.mjs --apply --only=file.webp  — только для указанного файла (можно повторять флаг)
 *   node scripts/sync-player-photos.mjs --apply --confirm=file.webp — применить файл, который не прошёл авто-пороги,
 *     но пользователь вручную подтвердил, что топ-кандидат верный (тоже можно повторять флаг)
 *   node scripts/sync-player-photos.mjs --all                    — расширить анализ на ВСЮ папку (старый бэклог), не пишет без --apply
 */
import fs from 'fs';
import path from 'path';
import { execFileSync } from 'child_process';
import { fileURLToPath } from 'url';
import mysql from 'mysql2/promise';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.resolve(__dirname, '..');
const PLAYERS_IMG_DIR = path.join(ROOT, '.distr/blocks/players/img');
const PLAYERS_PHP = path.join(ROOT, '.distr/pages/api/players.php');

const APPLY = process.argv.includes('--apply');
const ALL = process.argv.includes('--all');
const ONLY = new Set(
  process.argv
    .filter((a) => a.startsWith('--only='))
    .map((a) => a.slice('--only='.length).toLowerCase()),
);
// Файлы, которые пользователь явно подтвердил вручную — применяем топ-кандидата, даже если
// он не прошёл автоматические пороги (слабый score / неоднозначность).
const CONFIRM = new Set(
  process.argv
    .filter((a) => a.startsWith('--confirm='))
    .map((a) => a.slice('--confirm='.length).toLowerCase()),
);

/** Файлы в players/img, которых еще нет в git (новые, незакоммиченные) — это и есть "добавленные мной". */
function getNewFileNames() {
  const out = execFileSync('git', ['status', '--porcelain', '--', '.distr/blocks/players/img'], {
    cwd: ROOT,
    encoding: 'utf8',
  });
  const names = new Set();
  for (const line of out.split('\n')) {
    const m = line.match(/^\?\?\s+\.distr\/blocks\/players\/img\/(.+)$/);
    if (m) names.add(m[1].trim());
  }
  return names;
}

const NO_PHOTO_VALUES = new Set(['', 'default.jpg', 'default.png', 'default.webp']);

function readDbConfig() {
  const src = fs.readFileSync(PLAYERS_PHP, 'utf8');
  const grab = (name) => {
    const m = src.match(new RegExp(`\\$${name}\\s*=\\s*'([^']*)'`));
    if (!m) throw new Error(`Не найден $${name} в ${PLAYERS_PHP}`);
    return m[1];
  };
  return {
    host: grab('host'),
    user: grab('user'),
    password: grab('password'),
    database: grab('database'),
  };
}

// Варианты транслитерации для "спорных" букв — у разных людей ц/ж/х/щ пишутся по-разному.
const MULTI = {
  ж: ['zh', 'j'],
  х: ['h', 'kh'],
  ц: ['c', 'ts'],
  щ: ['sch', 'shch'],
  й: ['i', 'y', ''],
  ы: ['y', 'i'],
  ъ: [''],
  ь: [''],
  ю: ['yu', 'iu', 'u'],
  я: ['ya', 'ia', 'a'],
  е: ['e', 'ye'],
  ё: ['e', 'yo'],
};
const SINGLE = {
  а: 'a', б: 'b', в: 'v', г: 'g', д: 'd', з: 'z', и: 'i', к: 'k', л: 'l',
  м: 'm', н: 'n', о: 'o', п: 'p', р: 'r', с: 's', т: 't', у: 'u', ф: 'f',
  э: 'e', ч: 'ch', ш: 'sh',
};

// Ограничиваем взрыв вариантов, иначе длинные имена с кучей "спорных" букв дадут тысячи строк.
const MAX_VARIANTS = 48;

function transliterateVariants(word) {
  const lower = word.toLowerCase();
  let variants = [''];
  for (const ch of lower) {
    let opts;
    if (MULTI[ch]) opts = MULTI[ch];
    else if (SINGLE[ch] !== undefined) opts = [SINGLE[ch]];
    else if (/[a-z0-9]/.test(ch)) opts = [ch];
    else opts = [''];
    const next = [];
    for (const v of variants) {
      for (const o of opts) {
        next.push(v + o);
        if (next.length >= MAX_VARIANTS) break;
      }
      if (next.length >= MAX_VARIANTS) break;
    }
    variants = [...new Set(next)];
  }
  return variants;
}

function levenshtein(a, b) {
  const m = a.length, n = b.length;
  if (m === 0) return n;
  if (n === 0) return m;
  const dp = Array.from({ length: m + 1 }, () => new Array(n + 1).fill(0));
  for (let i = 0; i <= m; i++) dp[i][0] = i;
  for (let j = 0; j <= n; j++) dp[0][j] = j;
  for (let i = 1; i <= m; i++) {
    for (let j = 1; j <= n; j++) {
      dp[i][j] = a[i - 1] === b[j - 1]
        ? dp[i - 1][j - 1]
        : 1 + Math.min(dp[i - 1][j], dp[i][j - 1], dp[i - 1][j - 1]);
    }
  }
  return dp[m][n];
}

function similarity(a, b) {
  if (!a || !b) return 0;
  return 1 - levenshtein(a, b) / Math.max(a.length, b.length);
}

/** Возвращает лучший score (0..1) совпадения filename-основы с полным именем игрока ("Имя Фамилия"). */
function scoreFileAgainstName(fileBase, fullName) {
  const parts = fullName.trim().split(/\s+/).filter(Boolean);
  const candidateWords = new Set();
  for (const part of parts) {
    for (const v of transliterateVariants(part)) candidateWords.add(v);
  }
  const candidates = new Set(candidateWords);
  if (parts.length >= 2) {
    const firstVariants = transliterateVariants(parts[0]);
    const lastVariants = transliterateVariants(parts[1]);
    for (const f of firstVariants) {
      for (const l of lastVariants) {
        candidates.add(f + l);
        candidates.add(l + f);
      }
    }
  }

  let best = 0;
  for (const c of candidates) {
    if (!c) continue;
    if (c === fileBase) return 1;
    // Префиксное совпадение — покрывает и сокращения ("derg" -> "дергачев"), и полную транслитерацию.
    if (c.startsWith(fileBase) || fileBase.startsWith(c)) {
      const overlap = Math.min(c.length, fileBase.length) / Math.max(c.length, fileBase.length);
      best = Math.max(best, 0.85 + 0.15 * overlap);
      continue;
    }
    best = Math.max(best, similarity(fileBase, c));
  }
  return Math.min(best, 1);
}

const STRONG_THRESHOLD = 0.82;
const MIN_MARGIN_OVER_SECOND = 0.08;

async function main() {
  const dbConfig = readDbConfig();
  const allWebp = fs.readdirSync(PLAYERS_IMG_DIR).filter((f) => f.toLowerCase().endsWith('.webp'));

  let files = allWebp;
  if (!ALL) {
    const newNames = getNewFileNames();
    files = allWebp.filter((f) => newNames.has(f));
    console.log(`Режим: только новые (незакоммиченные) файлы. Найдено новых: ${files.length} из ${allWebp.length} в папке.`);
    console.log('(запусти с --all, чтобы разобрать и старый бэклог — отдельно, по согласованию)\n');
  }

  const conn = await mysql.createConnection(dbConfig);
  try {
    const [rows] = await conn.execute('SELECT id, name, username, photo FROM players');

    const alreadyUsedPhotos = new Set(
      rows.map((r) => (r.photo || '').trim().toLowerCase()).filter((p) => p && !NO_PHOTO_VALUES.has(p)),
    );
    const noPhotoPlayers = rows.filter((r) => NO_PHOTO_VALUES.has((r.photo || '').trim().toLowerCase()));

    const toApply = [];
    const skipped = [];

    for (const file of files) {
      const base = path.basename(file, '.webp').toLowerCase();
      if (alreadyUsedPhotos.has(file.toLowerCase())) continue; // уже привязан к кому-то

      const scored = noPhotoPlayers
        .map((p) => ({ player: p, score: scoreFileAgainstName(base, p.name) }))
        .sort((a, b) => b.score - a.score);

      const top = scored[0];
      const second = scored[1];
      const forced = CONFIRM.has(file.toLowerCase());

      if (!top) {
        skipped.push({ file, reason: 'нет кандидатов (все игроки уже с фото?)', top: '—' });
        continue;
      }
      if (!forced && top.score < STRONG_THRESHOLD) {
        skipped.push({ file, reason: 'нет уверенного совпадения', top: `${top.player.name} (${top.score.toFixed(2)})` });
        continue;
      }
      if (!forced && second && top.score - second.score < MIN_MARGIN_OVER_SECOND) {
        skipped.push({
          file,
          reason: 'неоднозначно',
          top: `${top.player.name} (${top.score.toFixed(2)})`,
          second: `${second.player.name} (${second.score.toFixed(2)})`,
        });
        continue;
      }

      toApply.push({ file, player: top.player, score: top.score, forced });
    }

    console.log(`Файлов найдено: ${files.length}`);
    console.log(`Игроков без фото: ${noPhotoPlayers.length}`);
    console.log('');

    if (toApply.length) {
      console.log(APPLY ? 'Применяю:' : 'Будет применено (запусти с --apply, чтобы записать в базу):');
      for (const a of toApply) {
        console.log(`  ${a.file} -> ${a.player.name} [id=${a.player.id}] (score ${a.score.toFixed(2)}${a.forced ? ', подтверждено вручную' : ''})`);
      }
    } else {
      console.log('Нечего применять.');
    }

    if (skipped.length) {
      console.log('\nПропущено (нужна ручная проверка):');
      for (const s of skipped) {
        console.log(`  ${s.file}: ${s.reason}; топ: ${s.top}${s.second ? `, второй: ${s.second}` : ''}`);
      }
    }

    if (APPLY && toApply.length) {
      const toWrite = ONLY.size ? toApply.filter((a) => ONLY.has(a.file.toLowerCase())) : toApply;
      for (const a of toWrite) {
        await conn.execute('UPDATE players SET photo = ? WHERE id = ?', [a.file, a.player.id]);
      }
      console.log(`\nЗаписано в базу: ${toWrite.length}${ONLY.size ? ` (из ${toApply.length} найденных, фильтр --only)` : ''}`);
    }
  } finally {
    await conn.end();
  }
}

main().catch((err) => {
  console.error('Ошибка:', err);
  process.exit(1);
});
