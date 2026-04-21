/**
 * Конвертирует PNG/JPEG в WebP для .distr/blocks/players/img и .../team/img.
 * При двух файлах с одним basename (например admin.png и admin.jpg) берётся PNG.
 */
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import sharp from 'sharp';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.resolve(__dirname, '../.distr/blocks');
const DIRS = ['players/img', 'team/img'];

const RASTER = new Set(['.png', '.jpg', '.jpeg']);
const PRIORITY = { '.png': 0, '.jpeg': 1, '.jpg': 2 };

function collectWinnerByBasename(dir) {
  /** @type {Map<string, { full: string, pri: number }>} */
  const map = new Map();
  const names = fs.readdirSync(dir).filter((n) => !n.startsWith('.'));
  for (const name of names) {
    const full = path.join(dir, name);
    const st = fs.statSync(full);
    if (!st.isFile()) continue;
    const ext = path.extname(name).toLowerCase();
    if (!RASTER.has(ext)) continue;
    const base = path.basename(name, ext);
    const pri = PRIORITY[ext] ?? 9;
    const prev = map.get(base);
    if (!prev || pri < prev.pri) map.set(base, { full, pri });
  }
  return map;
}

async function convertDir(rel) {
  const dir = path.join(ROOT, rel);
  if (!fs.existsSync(dir)) {
    console.warn('skip missing:', dir);
    return;
  }
  const winners = collectWinnerByBasename(dir);
  for (const [base, { full }] of winners) {
    const outPath = path.join(dir, `${base}.webp`);
    await sharp(full)
      .webp({ quality: 85, effort: 4 })
      .toFile(outPath);
    console.log('ok', path.relative(ROOT, outPath));
    try {
      fs.unlinkSync(full);
    } catch (e) {
      console.warn('could not delete source (close programs using the file):', path.relative(ROOT, full), e.message);
    }
  }
  // удалить проигравшие дубликаты по basename (второй файл с тем же именем без webp)
  const remaining = fs.readdirSync(dir);
  for (const name of remaining) {
    const full = path.join(dir, name);
    if (!fs.statSync(full).isFile()) continue;
    const ext = path.extname(name).toLowerCase();
    if (!RASTER.has(ext)) continue;
    const base = path.basename(name, ext);
    const webpPath = path.join(dir, `${base}.webp`);
    if (fs.existsSync(webpPath)) {
      try {
        fs.unlinkSync(full);
        console.log('removed duplicate raster:', path.relative(ROOT, full));
      } catch (e) {
        console.warn('could not delete duplicate:', path.relative(ROOT, full), e.message);
      }
    }
  }
}

for (const rel of DIRS) {
  await convertDir(rel);
}
console.log('done');
