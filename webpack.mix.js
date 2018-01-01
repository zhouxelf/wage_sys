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

mix.js('resources/assets/js/admin/admin.js', 'public/js/admin.js')
   .js('resources/assets/js/common/common.js', 'public/js/common.js')
   .js('resources/assets/js/wechat/wechat.js', 'public/js/wechat.js')
   .extract(['vue', 'vue-router', 'element-ui'])
   .copy('resources/assets/sass/app.css', 'public/css')
   .copy('resources/assets/library/css', 'public/css')
   .copy('resources/assets/library/fonts', 'public/fonts')
   .copy('resources/assets/library/js', 'public/js');
