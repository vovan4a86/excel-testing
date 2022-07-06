let mix = require('laravel-mix');

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
mix.sourcemaps = false;
mix.browserSync({
    proxy: 'regionmetprom2021.test'
});
mix.scripts([
        'resources/assets/js/libs.js',
        'resources/assets/js/main.js',
        'resources/assets/js/animations.js',
        'resources/assets/js/interface.js'
    ], 'public/static/js/all.js')
    .styles([
        'resources/assets/css/styles.css',
        'resources/assets/css/custom_styles.css',
    ], 'public/static/css/all.css')
    .version();
