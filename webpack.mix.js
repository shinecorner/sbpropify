// DO NOT FORGET TO DO -> NPM INSTALL AGAIN (older version of laravel-mix)
const mix = require('laravel-mix');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const CompressionPlugin = require('compression-webpack-plugin')
const CleanWebpackPlugin = require('clean-webpack-plugin')
 
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

mix
    .options({
        extractVueStyles: true,
        clearConsole: true
    })
    .copy('resources/fonts', 'public/fonts')
    .sass('resources/sass/app.scss', 'public/css/app.css')
    .combine([
        'public/css/app.css',
        'resources/css/fontello.css'
    ], 'public/css/app.css')
    .js('resources/js/app.js', 'public/js')
    .extract([
        'vue',
        'vuex',
        'axios',
        'vue-axios',
        'v-router-transition',
        'vue2-editor',
        'vue-apexcharts',
        'vue-avatar',
        'vue-content-loader',
        'vue-croppie',
        'vue-debounce',
        'vue-gallery',
        'vue-i18n',
        'vue-quill-editor',
        'vue-read-more',
        'vue-responsive-components',
        'vue-router',
        // 'vue-rss-feed',
        'vue-sticky',
        'vue-sticky-directive',
        'vue-sweetalert2',
        'vue-uid',
        'vue-upload-component',
        'vue-virtual-scroll-list',
        'vue-virtual-scroller',
        'vuedraggable',
        'apexcharts',
        'date-fns',
        'element-ui',
        'lodash',
        'p-queue',
        'query-string',
        'rss-parser',
        'uuid'
    ])
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve('resources/js'),
                'img': path.resolve('resources/img'),
                'sass': path.resolve('resources/sass'),
                'components': path.resolve('resources/js/components'),
                'helpers': path.resolve('resources/js/helpers'),
                'lang': path.resolve('resources/js/lang'),
                'layouts': path.resolve('resources/js/layouts'),
                'middlewares': path.resolve('resources/js/middlewares'),
                'mixins': path.resolve('resources/js/mixins'),
                'store': path.resolve('resources/js/store'),
                'views': path.resolve('resources/js/views')
            }
        }
    })
    .version()
    .disableNotifications();

if (mix.inProduction()) {
    mix
        .options({
            uglify: {
                // exclude: /\/vendor.js(\?.*)?$/,
                uglifyOptions: {
                    compress: {
                        ecma: 6,
                        drop_console: true
                    },
                    output: {
                        ecma: 6,
                        comments: false
                    }
                }
            }
        })
        .webpackConfig({
            output: {
                filename: '[name].js?id=[hash]',
                chunkFilename: 'js/[chunkhash].js?id=[hash]'
            },
            plugins: [
                new CleanWebpackPlugin(['public/js/**/*']),
                new CompressionPlugin({
                    asset: "[path].gz[query]",
                    algorithm: "gzip",
                    test: /\.js(\?.*)?$|\.css(\?.*)?$|\.html(\?.*)?$|\.woff2(\?.*)?$|\.ttf(\?.*)?$|\.svg(\?.*)?$|\.woff(\?.*)?$|\.eot(\?.*)?$/,
                })
            ]
        })
} else {
    mix.webpackConfig({
        devtool: 'inline-source-map',
        output: {
            filename: '[name].js',
            chunkFilename: 'js/[name].js',
        },
        plugins: [
            new BundleAnalyzerPlugin({
                openAnalyzer: false
            })
        ]
    }).sourceMaps();
}