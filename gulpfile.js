// ## Globals
var argv         = require('minimist')(process.argv.slice(2));
var autoprefixer = require('gulp-autoprefixer');
var browserSync  = require('browser-sync').create();
var concat       = require('gulp-concat');
var del          = require('del');
var flatten      = require('gulp-flatten');
var gulp         = require('gulp');
var gulpif       = require('gulp-if');
var cleanCss     = require('gulp-clean-css');
var plumber      = require('gulp-plumber');
var rev          = require('gulp-rev');
var sass         = require('gulp-sass')(require('sass'));
var sourcemaps   = require('gulp-sourcemaps');
var uglify       = require('gulp-uglify');
var manifest     = require('./lib/gulp-manifest')('./assets/manifest.json');

var path = manifest.paths;
var config = manifest.config || {};
var globs = manifest.globs;

var enabled = {
  rev: argv.production,
  maps: !argv.production,
  failStyleTask: argv.production,
  stripJSDebug: argv.production
};

var revManifest = path.dist + 'assets.json';

function styles() {
  var stream = gulp.src('assets/styles/main.scss', {sourcemaps: enabled.maps})
    .pipe(gulpif(!enabled.failStyleTask, plumber()))
    .pipe(gulpif(enabled.maps, sourcemaps.init()))
    .pipe(sass({
      outputStyle: enabled.rev ? 'compressed' : 'expanded',
      includePaths: [path.source + 'styles'],
      quietDeps: true
    }).on('error', sass.logError))
    .pipe(concat('main.css'))
    .pipe(autoprefixer({
      overrideBrowserslist: [
        'last 2 versions',
        'android 4',
        'opera 12'
      ]
    }))
    .pipe(cleanCss({
      advanced: false,
      rebase: false
    }))
    .pipe(gulpif(enabled.rev, rev()))
    .pipe(gulpif(enabled.maps, sourcemaps.write('.')))
    .pipe(gulp.dest(path.dist + 'styles'))
    .pipe(gulpif(enabled.rev, rev.manifest(revManifest, {
      base: path.dist,
      merge: true
    })))
    .pipe(gulp.dest(path.dist));

  if (browserSync.active) {
    stream = stream.pipe(browserSync.stream());
  }

  return stream;
}

function buildScripts(entry, outputName) {
  return gulp.src(entry, {sourcemaps: enabled.maps})
    .pipe(gulpif(enabled.maps, sourcemaps.init()))
    .pipe(concat(outputName))
    .pipe(uglify({
      compress: {
        drop_debugger: enabled.stripJSDebug
      }
    }))
    .pipe(gulpif(enabled.rev, rev()))
    .pipe(gulpif(enabled.maps, sourcemaps.write('.')))
    .pipe(gulp.dest(path.dist + 'scripts'))
    .pipe(gulpif(enabled.rev, rev.manifest(revManifest, {
      base: path.dist,
      merge: true
    })))
    .pipe(gulp.dest(path.dist));
}

function scripts() {
  return buildScripts('assets/scripts/main.js', 'main.js');
}

function customizer() {
  return buildScripts('assets/scripts/customizer.js', 'customizer.js');
}

function fonts() {
  var stream = gulp.src(globs.fonts)
    .pipe(flatten())
    .pipe(gulp.dest(path.dist + 'fonts'));

  if (browserSync.active) {
    stream = stream.pipe(browserSync.stream());
  }

  return stream;
}

function images() {
  var stream = gulp.src(globs.images, {encoding: false})
    .pipe(gulp.dest(path.dist + 'images'));

  if (browserSync.active) {
    stream = stream.pipe(browserSync.stream());
  }

  return stream;
}

function clean() {
  return del([path.dist]);
}

function watch() {
  browserSync.init({
    files: ['{lib,templates}/**/*.php', '*.php'],
    proxy: config.devUrl,
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    }
  });
  gulp.watch([path.source + 'styles/**/*'], styles);
  gulp.watch([path.source + 'scripts/**/*'], scripts);
  gulp.watch([path.source + 'fonts/**/*'], fonts);
  gulp.watch([path.source + 'images/**/*'], images);
  gulp.watch(['bower.json', 'assets/manifest.json'], build);
}

var build = gulp.series(styles, scripts, customizer, gulp.parallel(fonts, images));

exports.styles = styles;
exports.scripts = gulp.series(scripts, customizer);
exports.fonts = fonts;
exports.images = images;
exports.clean = clean;
exports.watch = gulp.series(build, watch);
exports.build = build;
exports.default = gulp.series(clean, build);
