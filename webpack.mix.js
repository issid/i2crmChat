let mix = require('laravel-mix');
mix.setPublicPath("./web");
mix.js('vue/app.js', 'web/js');
