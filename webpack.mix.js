const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setPublicPath(path.normalize('./web'))
    .js('src/js/app.js', 'assets/js')
    .sass('src/scss/app.scss', 'assets/css')
    .copy('src/favicon', 'assets/favicon')
    .version();