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

mix.setPublicPath(path.resolve('./'))
    .js('src/js/app.js', 'web/assets/js')
    .sass('src/scss/app.scss', 'web/assets/css')
    .copy('src/img', 'web/assets/img')
    .copy('src/favicon', 'web/assets/favicon')
    .version();