const gulp = require('gulp');
const sass = require('gulp-sass');
const del = require('del');
const concat = require('gulp-concat');
const gulpif = require('gulp-if');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const sourcemaps = require('gulp-sourcemaps');
const zip = require('gulp-zip');
const babel = require('gulp-babel');
const uglify = require('gulp-uglify');

let prod = process.env.NODE_ENV === 'production';

const paths = {
    build : {
        js : 'assets/js/',
        css : 'assets/css/',
    },
    src : {
        js : 'src/js/',
        scss : 'src/scss/',
    },
    watch: {
        js : 'src/js/**/*',
        scss : 'src/scss/**/*'
    },
    clean: [
        'assets/js/**/*',
        'assets/css/**/*',
    ],
};

const postCssPlugins = [
    autoprefixer(),
];

if (prod) {
    postCssPlugins.push(cssnano());
}

gulp.task('clean', function () {
    return del(paths.clean);
});

gulp.task('scss:form-component', function () {
    return gulp.src([
        paths.src.scss + 'form-component.scss',
    ])
        .pipe(gulpif(!prod, sourcemaps.init()))
        .pipe(sass({
            noCache: true,
            style: 'compressed',
            includePaths: [
                'node_modules',
            ]
        }))
        .pipe(postcss(postCssPlugins))
        .pipe(concat('form-component.min.css'))
        .pipe(gulpif(!prod, sourcemaps.write('.')))
        .pipe(gulp.dest(paths.build.css));
});

const jsUglifyCondition = function(file) {
    if (!prod) {
        return false;
    }

    if (file.path.match(/node_modules/g)) {
        return false;
    }

    return true;
};

gulp.task('js:form-component', function () {
    return gulp.src([
        paths.src.js + 'form-component.js',
    ])
        .pipe(gulpif(!prod, sourcemaps.init()))
        .pipe(babel())
        .pipe(gulpif(jsUglifyCondition, uglify({mangle: false})))
        .pipe(concat('form-component.min.js'))
        .pipe(gulpif(!prod, sourcemaps.write('.')))
        .pipe(gulp.dest(paths.build.js));
});

gulp.task('scss', gulp.parallel(
    'scss:form-component',
));

gulp.task('js', gulp.parallel(
    'js:form-component',
));

gulp.task('watch',  gulp.parallel(function () {
    gulp.watch(paths.watch.scss, gulp.parallel('scss'));
    gulp.watch(paths.watch.js, gulp.parallel('js'));
}));

gulp.task('zip', function () {
    return gulp.src([
        './assets/**/*',
        '!./assets/manifest/',
        '!./assets/manifest/**/*',
        './classes/**/*.php',
        './components/**/*',
        './config/**/*.php',
        './lang/**/*.php',
        './updates/**/*',
        './views/**/*',
        './Plugin.php',
        './plugin.yaml',
    ], {base: '.'})
        .pipe(zip('forms.zip'))
        .pipe(gulp.dest('.'));
});

gulp.task('build', gulp.series('clean', gulp.parallel('scss', 'js'), 'zip'));

gulp.task('default', gulp.series('build'));
