import {src, dest, watch, series} from 'gulp'
import * as dartSass from 'sass'
import terser from 'gulp-terser'
import gulpSass from 'gulp-sass'

const sass = gulpSass(dartSass)

export function css(done) {
    src('src/scss/**/*.scss')
    .pipe(sass( {outputStyle : "compressed"} ))
    .pipe(dest('public/build/css'))
    done()
}

export function js(done) {
    src('src/js/**/*.js')
    .pipe( terser() )
    .pipe(dest('public/build/js'))
    done()
}

export function gulp() {
    watch('src/scss/**/*.scss', css)
    watch('src/js/**/*.js', js)
}

export default series(css, js, gulp)