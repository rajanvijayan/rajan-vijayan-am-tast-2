const gulp = require('gulp');
const notify = require('gulp-notify');
const wpPot = require('gulp-wp-pot');

// Define a task to generate POT file
gulp.task('pot', function () {
    return gulp.src('./src/**/*.php')
        .pipe(wpPot({
            domain: 'rajan-vijayan',
            destFile: './language/rajan-vijayan.pot',
            package: 'Rajan Vijayan',
        }))
        .pipe(gulp.dest('./language/rajan-vijayan.pot'))
        .pipe(notify('POT file generated successfully!'));
});

// Define a default task
gulp.task('default', gulp.series('pot'));
