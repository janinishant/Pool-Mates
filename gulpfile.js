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
    mix.scripts([
        'resources/assets/js/*.js'
    ], '', './');
    mix.styles([
        'resources/assets/css/*.css'
    ], '', './');
    mix.version([
        'css/all.css',
        'js/all.js'
    ]);
    mix.copy('fonts', 'public/fonts')
});
