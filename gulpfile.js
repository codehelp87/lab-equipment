var elixir = require('laravel-elixir');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    /**
     * Merge all online community js files into scripts.js in public/js
     *
     * run gulp --production to minify
     */
    mix.scripts([
        'jquery.min.js',
        'keep_alive.js',
        'add_equipment.js',
        'bootbox.min.js',
        'book_equipment.js',
        'jquery.table2excel.min.js',
        'lab.js',
        'lab_usage.js',
        'moment.js',
        'notification.js',
        'training_request.js',
        'user.js',
    ], 'public/js/main.js', 'public/js');

    /**
     * Merge css files into styles.css in public/css
     */
    mix.styles([
        'main.css',
        'bootstrap.css',
        'app.css',
    ], 'public/css/main.css', 'public/css');
});
