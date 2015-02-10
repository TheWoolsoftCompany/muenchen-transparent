var gulp = require('gulp'),
    uglify = require('gulp-uglifyjs'),
    concat = require('gulp-concat'),
    concatCss = require('gulp-concat-css'),
    minifyCSS = require('gulp-minify-css');

gulp.task('default', function () {
    gulp.src(["./html/js/jquery-ui-1.11.2.custom.min.js", "./html/js/scrollintoview.js", "./html/js/antraegekarte.jquery.js",
        "./html/js/bootstrap.min.js", "./html/js/material/ripples.min.js", "./html/js/material/material.min.js",
        "./html/js/typeahead.js/typeahead.bundle.min.js", "./html/js/index.js"])

        .pipe(concat('std.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./html/js/build/'));

    gulp.src(["./html/js/leaflet/dist/leaflet.js", "./html/js/Leaflet.Fullscreen/Control.FullScreen.js",
        "./html/js/Leaflet.Control.Geocoder/Control.Geocoder.js", "./html/js/Leaflet.draw-0.2.3/dist/leaflet.draw.js",
        "./html/js/leaflet.spiderfy.js", "./html/js/leaflet.textmarkers.js", "./html/js/leaflet.locatecontrol/dist/L.Control.Locate.min.js"])

        .pipe(concat('leaflet.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./html/js/build/'));

    gulp.src(['./html/js/leaflet/dist/leaflet.css', './html/js/Leaflet.Control.Geocoder/Control.Geocoder.css',
        './html/js/leaflet.locatecontrol/dist/L.Control.Locate.min.css',
        './html/css/jquery-ui-1.11.2.custom.min.css', './html/css/styles_website.css'
    ])
        .pipe(concatCss("std.css"))
        .pipe(minifyCSS())
        .pipe(gulp.dest('./html/css/build/'));
});

