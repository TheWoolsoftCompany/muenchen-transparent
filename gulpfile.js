var gulp       = require('gulp'),
    concat     = require('gulp-concat'),
    gulpif     = require('gulp-if'),
    sass       = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify     = require('gulp-uglify'),
    gutil      = require('gulp-util'),
    exec       = require('child_process').exec;

// browsersync will only be used with the browsersync task
var browsersync = require('browser-sync').create();
var use_browsersync = false;

// setting this to false makes debugging easier and building the js a hundred times faster
var use_uglify = true;

var paths = {
    source_styles: ["html/css/*.scss"],
    source_js: ["html/js/**/*.js", "html/bower/**/*.js", "!html/js/build/*.js"],
    build_js: ["html/js/build/*.js"],
    php: ["protected/**/*.php"],
    std_js: [
        "html/bower/typeahead.js/dist/typeahead.bundle.min.js",
        "html/bower/bootstrap-sass/assets/javascripts/bootstrap.min.js",
        "html/js/jquery-ui-1.11.2.custom.min.js",
        "html/js/scrollintoview.js",
        "html/js/material/ripples.min.js",
        "html/js/material/material.min.js",
        "html/js/custom/*.js",
    ],
    leaflet_js: [
        "html/bower/leaflet/dist/leaflet.js",
        "html/bower/Leaflet.draw/dist/leaflet.draw.js",
        "html/bower/leaflet.locatecontrol/dist/L.Control.Locate.min.js",
        "html/js/Leaflet.Fullscreen/Control.FullScreen.js",
        "html/js/Leaflet.Control.Geocoder/Control.Geocoder.js",
        "html/js/leaflet.spiderfy.js",
        "html/js/leaflet.textmarkers.js",
    ],
}

gulp.task('default', ['std.js', 'leaflet.js', 'sass', 'ba_grenzen_geojson']);

gulp.task('watch', function () {
    use_uglify = false; // much better performance 
    gulp.watch(paths.source_js, ['std.js', 'leaflet.js']);
    gulp.watch(paths.source_styles, ['sass']);
});

gulp.task('browsersync', ['watch'], function() {
    use_browsersync = true;
    browsersync.init({
        proxy: "ratsinformant.local"
    });

    gulp.watch(paths.build_js).on("change", browsersync.reload);
    gulp.watch(paths.php     ).on("change", browsersync.reload);
});

// helper tasks

gulp.task('std.js', function () {
    return gulp.src(paths.std_js)
        .pipe(concat('std.js'))
        .pipe(gulpif(use_uglify, uglify()))
        .pipe(gulp.dest('html/js/build/'));
});

gulp.task('leaflet.js', function () {
    return gulp.src(paths.leaflet_js)
        .pipe(concat('leaflet.js'))
        .pipe(gulpif(use_uglify, uglify()))
        .pipe(gulp.dest('html/js/build/'));
});

gulp.task('sass', function () {
    return gulp.src(paths.source_styles)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('html/css/build/'))
        .pipe(gulpif(use_browsersync, browsersync.stream({match: "**/*.css"})));
});

gulp.task('ba_grenzen_geojson', function () {
    return exec('protected/yiic bagrenzengeojson html/js/ba_grenzen_geojson.js');
});
