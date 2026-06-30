const { src, dest, watch, series, parallel } = require('gulp');
const argv = require('minimist')(process.argv.slice(2));
const autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();
const concat = require('gulp-concat');
const del = require('del');
const flatten = require('gulp-flatten');
const gulpif = require('gulp-if');
const imagemin = require('gulp-imagemin');
const plumber = require('gulp-plumber');
const rev = require('gulp-rev');
const sassCompiler = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');

const manifest = require('./assets/manifest.json');
const path = manifest.paths || { source: 'assets/', dist: 'dist/' };
const config = manifest.config || {};

const enabled = {
  rev: Boolean(argv.production),
  maps: !argv.production,
  failStyleTask: Boolean(argv.production),
  stripJSDebug: Boolean(argv.production),
};

const revManifest = path.dist + 'assets.json';

function styles() {
  return src('assets/styles/main.scss', { base: 'assets/styles' })
    .pipe(gulpif(!enabled.failStyleTask, plumber()))
    .pipe(gulpif(enabled.maps, sourcemaps.init()))
    .pipe(sassCompiler({
      outputStyle: 'compressed',
      precision: 10,
      includePaths: ['node_modules'],
      quietDeps: true,
    }).on('error', sassCompiler.logError))
    .pipe(autoprefixer({ cascade: false }))
    .pipe(concat('main.css'))
    .pipe(gulpif(enabled.rev, rev()))
    .pipe(gulpif(enabled.maps, sourcemaps.write('.')))
    .pipe(dest(path.dist + 'styles'))
    .pipe(gulpif(enabled.rev, rev.manifest(revManifest, { base: path.dist, merge: true })))
    .pipe(gulpif(enabled.rev, dest(path.dist)))
    .pipe(browserSync.stream({ match: '**/*.css' }));
}

function scripts() {
  return src(['assets/scripts/main.js'], { base: 'assets/scripts' })
    .pipe(gulpif(enabled.maps, sourcemaps.init()))
    .pipe(concat('main.js'))
    .pipe(uglify({
      compress: { drop_debugger: enabled.stripJSDebug },
    }))
    .pipe(gulpif(enabled.rev, rev()))
    .pipe(gulpif(enabled.maps, sourcemaps.write('.')))
    .pipe(dest(path.dist + 'scripts'))
    .pipe(gulpif(enabled.rev, rev.manifest(revManifest, { base: path.dist, merge: true })))
    .pipe(gulpif(enabled.rev, dest(path.dist)))
    .pipe(browserSync.stream({ match: '**/*.js' }));
}

function customizer() {
  return src('assets/scripts/customizer.js', { base: 'assets/scripts' })
    .pipe(concat('customizer.js'))
    .pipe(dest(path.dist + 'scripts'));
}

function fonts() {
  return src(path.source + 'fonts/**/*')
    .pipe(flatten())
    .pipe(dest(path.dist + 'fonts'))
    .pipe(browserSync.stream());
}

function images() {
  return src(path.source + 'images/**/*')
    .pipe(imagemin())
    .pipe(dest(path.dist + 'images'))
    .pipe(browserSync.stream());
}

function clean() {
  return del([path.dist]);
}

function serve() {
  browserSync.init({
    files: ['{lib,templates}/**/*.php', '*.php'],
    proxy: config.devUrl,
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**'],
    },
  });

  watch('assets/styles/**/*', styles);
  watch('assets/scripts/**/*', series(scripts, customizer));
  watch(path.source + 'fonts/**/*', fonts);
  watch(path.source + 'images/**/*', images);
}

exports.styles = styles;
exports.scripts = series(scripts, customizer);
exports.fonts = fonts;
exports.images = images;
exports.clean = clean;
exports.watch = series(parallel(styles, scripts, customizer, fonts, images), serve);
exports.build = parallel(styles, series(scripts, customizer), fonts, images);
exports.default = series(clean, exports.build);
