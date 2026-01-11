
const { src, dest, parallel, series, watch } = require('gulp');

const sass = require('gulp-sass')(require('sass'));
// const concat = require('gulp-concat');
const browserSync = require('browser-sync').create();
const connectPhp = require('gulp-connect-php');
const include = require('gulp-include');
const revReplace = require('gulp-rev-replace');
const plumber = require('gulp-plumber');
const nunjucksRender = require('gulp-nunjucks-render');
const debug = require('gulp-debug');
const changed = require('gulp-changed');
const rename = require('gulp-rename');
const os = require('os');
const clean = require('gulp-clean');
const del = require('del');
const autoprefixer = require('gulp-autoprefixer');
const gulpif = require('gulp-if');
const fonter = require('gulp-fonter');
const ttf2woff2 = require('gulp-ttf2woff2');

/* Конфиг */
var CONFIG = {
	output: 'public', /* Корневая папка сборки */
	input: '.distr/', /* Корневая папка дистрибутива */
	pages: '.distr/pages', /* Структура сайта в дистрибутиве */
	templates: '.distr/templates', /* Шаблоны сайта в дистрибутиве */
	blocks: '.distr/blocks', /* Блоки сайта в дистрибутиве */
	useAutoprefixer: true, /* Autoprefixer по умолчанию включен */
	reload: true, /* Перезагрузка браузера по умолчанию влючена */
	phpPath: '', /* Путь к локально установленному PHP, задаётся только в gulpconfig.json */
};

function fonts() {
	return src('.distr/pages/css/fonts/*.*')
		.pipe(fonter({
			formats: ['woff', 'ttf']
		}))
		.pipe(ttf2woff2())
		.pipe(dest(CONFIG.output))
}

/* Задача для копирования остальных файлов */
function pages() {
	console.log('* Копирование остальных файлов *');

	return src(['**/**', '!**/*.{php,scss,js}', '!{~**/**,**/~**}', '!**/~*.*'], { cwd: CONFIG.pages, dot: true })
		.pipe(dest(CONFIG.output))
		;
};

/* Задача для копирования API файлов */
function api() {
	console.log('* Копирование API файлов *');

	return src(['**/*.php'], { cwd: CONFIG.input + 'api', dot: true })
		.pipe(dest(CONFIG.output + '/api'))
		;
};

/* Задача для копирования модулей турнира */
function tournamentModules() {
	console.log('* Копирование модулей турнира *');

	return src(['tournament/modules/**/*.js'], { cwd: CONFIG.blocks, dot: true })
		.pipe(dest(CONFIG.output + '/tournament/modules'))
		;
};


/* Задача для замены имён файлов в HTML и CSS */
function revreplace(callback) {
	console.log('* Замена имён файлов *');

	return src(['**/*.php', '**/*.css'], { cwd: CONFIG.output })
		.pipe(plumber())
		.pipe(revReplace({
			replaceInExtensions: ['.php', '.css'],
		}))
		.pipe(revReplace({
			replaceInExtensions: ['.php', '.css'],
		}))
		.pipe(revReplace({
			replaceInExtensions: ['.php'],
		}))
		.pipe(debug({ title: 'revReplace + manifest' }))
		.pipe(dest(CONFIG.output))
		;
};


/* Задача для JS */
function scripts() {
	console.log('* Копирование скриптов *');
	return src(['**/*.js', '!{~**/**,**/~**}/*.js', '!**/~*.js'], { cwd: CONFIG.pages, dot: true })
		.pipe(include({
			includePaths: [CONFIG.blocks]
		}))
		// .pipe(uglify()) /* сжатый js */
		.pipe(dest(CONFIG.output));
};

/* Задача для CSS */
function styles() {
	console.log('* Копирование стилей *');
	return src(['**/*.scss', '!{~**/**,**/~**}/*.scss', '!**/~*.scss'], { cwd: CONFIG.pages, dot: true })
		.pipe(sass({
			includePaths: [CONFIG.blocks],
			indentType: 'tab',
			indentWidth: 1,
			outputStyle: 'compact',
			outputStyle: 'expanded'
			// outputStyle: 'compressed' /* сжатый css */
		}).on('error', sass.logError))
		.pipe(gulpif(CONFIG.useAutoprefixer, autoprefixer({ overrideBrowserslist: ['last 10 versions'] })))
		.pipe(dest(CONFIG.output))
};

/* Задача для картинок */
function images() {
	console.log('* Копирование картинок *');

	return src(['**/img/**/*.*', '!{~**/**,**/~**}/img/**/*.*', '!**/img/**/{~*.*,*.ps}'], { cwd: CONFIG.blocks, dot: true })
		.pipe(changed(CONFIG.output + '/img/'))
		.pipe(rename(function (path) {
			let slash = '/';
			if (os.type() == 'Windows_NT') slash = '\\';
			path.dirname = path.dirname.replace(slash + 'img', ''); /* Замена пути к картинкам для конечного пути: block/img/*.* -> img/block/*.* */
		}))
		.pipe(dest(CONFIG.output + '/img/'));
};


/* Задача для рендеринга шаблонов Nunjucks */
function nunjucks() {
	console.log('* Рендеринг шаблонов (Nunjucks) *');

	return src(['**/*.{php,njk}', '!{~**/**,**/~**}/*.{php,njk}', '!**/~*.{php,njk}'], { cwd: CONFIG.pages, dot: true })
		.pipe(nunjucksRender({
			path: [CONFIG.templates, CONFIG.blocks],
			inheritExtension: true,
			throwOnUndefined: true
		})
		)
		.pipe(dest(CONFIG.output))
		;
};


function watching() {
	/* Копирование, когда изменились картинки  */
	watch('**/img/*.{jpg,png,gif,svg}', { cwd: CONFIG.blocks }, series(images, revreplace));
	/* Пересборка CSS, когда изменились стили  */
	watch('**/*.scss', { cwd: CONFIG.input }, series(styles, revreplace));
	/* Пересборка JS, когда изменились скрипты  */
	watch('**/*.js', { cwd: CONFIG.input }, series(scripts, revreplace));
	/* Пересборка HTML, когда изменились страницы, шаблоны или блоки */
	watch('**/*.{php,njk}', { cwd: CONFIG.input }, series(nunjucks, revreplace));
	/* Обработка остальных файлов */
	watch('**/*.*', { cwd: CONFIG.pages }, pages);
}

function sync() {
	connectPhp.server({
		base: 'public/',
	}, function () {
		browserSync.init({
			ui: false,
			proxy: '127.0.0.1:8000',
			open: false,
			reloadOnRestart: true,
			injectChanges: true
		});
	});
	watch(['**/*.*', '!.distr/**'], { cwd: CONFIG.input }).on('change', browserSync.reload);
}

function cleanPublic() {
	// Очищаем public, но исключаем папку api (она управляется вручную на FTP)
	return del([
		'public/**/*',
		'!public/api',
		'!public/api/**'
	]);
}

// exports.
exports.delete = cleanPublic;
exports.fonts = fonts;
exports.public = series(cleanPublic, images, parallel(nunjucks, styles, scripts, pages, tournamentModules));
exports.default = series(cleanPublic, parallel(styles, scripts, pages, images, nunjucks, tournamentModules, sync, watching))