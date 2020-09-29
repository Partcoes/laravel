var gulp = require('gulp');

gulp.task("copy", function() {

    // bootstrapValidator
    gulp.src("vendor/bower/bootstrapvalidator/dist/css/bootstrapvalidator.min.css")
        .pipe(gulp.dest("public/css/"));
    gulp.src("vendor/bower/bootstrapvalidator/dist/js/bootstrapvalidator.min.js")
        .pipe(gulp.dest("public/js/"));
});
