let mix = require('laravel-mix');

mix.sass(
    'resources/assets/sass/app.scss',
    'public/css/app.css');

mix.js([
    'resources/assets/js/app.js',
], 'public/js/app.js');