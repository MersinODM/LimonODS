const mix = require('laravel-mix')
require('laravel-mix-bundle-analyzer')
// const webpack = require('webpack')
const CompressionPlugin = require('compression-webpack-plugin')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// const webpack = require('webpack');
// mix.webpackConfig({
//     plugins: [
//         // Define Bundler Build Feature Flags
//         new webpack.DefinePlugin({
//             // Drop Options API from bundle
//             __VUE_OPTIONS_API__: false,
//         })
//     ]
// })

mix.webpackConfig({
    externals: {
        jquery: 'jQuery',
        'jquery.dataTables': 'jquery.dataTables',
        bootstrap: 'bootstrap'
    }
})

// mix.autoload({
//   jquery: ['$', 'jQuery', 'window.jQuery'],
//   'jquery.dataTables': 'jquery.dataTables',
//   bootstrap: 'bootstrap'
// })

mix.copyDirectory('resources/images', 'public/images')
// mix.copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css/bootstrap.min.css')
mix.copyDirectory('node_modules/@mdi/font/fonts', 'public/fonts')

mix.js('resources/js/app.js', 'public/js')
  .vue({ version: 3 })
  .sass('resources/css/app.sass', 'public/css')
  .options({
      processCssUrls: false
  })
  .extract()

if (!mix.inProduction()) {
    mix.sourceMaps()
}

if (mix.inProduction()) {
    // mix.setResourceRoot('/otomasyon')
    mix.webpackConfig({
        plugins: [
            new CompressionPlugin({
                algorithm: 'gzip',
                test: /\.js$|\.css$|\.html$|\.svg$/,
                minRatio: 0.8
            })
        ]
    })
}

mix.bundleAnalyzer()
