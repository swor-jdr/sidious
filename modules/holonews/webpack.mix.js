const mix = require('laravel-mix');
const webpack = require('webpack');
const tailwindcss = require('tailwindcss');

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

mix.options({
    uglify: {
        uglifyOptions: {
            compress: {
                drop_console: true,
            },
        },
    },
    processCssUrls: false,
}).webpackConfig({
    plugins: [new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)],
});

const pathConfig = {
    public: mix.inProduction() ? 'public' : '../../public/vendor/holonews',
    destination: mix.inProduction() ? 'public' : './',
};

mix.setPublicPath(pathConfig.public)
    .js('resources/js/app.js', pathConfig.destination)
    .sass('resources/sass/light.scss', pathConfig.destination, {}, [tailwindcss('./light.js')])
    .version();

mix.sass('resources/sass/dark.scss', pathConfig.destination, {}, [tailwindcss('./dark.js')])
    .version()
    .copy('resources/favicon.png', pathConfig.destination)
    .copy('public', '../winktest/public/vendor/wink');
