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

mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap/dist/js/bootstrap.js',
    'node_modules/bootbox/dist/bootbox.min.js',
    'node_modules/blueimp-file-upload/js/vendor/jquery.ui.widget.js',
    'node_modules/blueimp-file-upload/js/jquery.iframe-transport.js',
    'node_modules/blueimp-file-upload/js/jquery.fileupload.js',
    'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
    'public/assets/js/default.js',
    ], 'public/assets/js/build.js');

mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css',
    'node_modules/font-awesome/css/font-awesome.css',
    'node_modules/blueimp-file-upload/css/jquery.fileupload.css',
    'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
    'public/assets/css/default.css',
], 'public/assets/css/build.css');
