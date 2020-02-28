const mix = require('laravel-mix');

require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + 'js/app.js', 'js/entidades.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/entidades.css');

if (mix.inProduction()) {
    mix.version();
}