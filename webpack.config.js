'use strict';

var path = require('path');
var webpack = require('./app-webpack/node_modules/webpack');
// var ExtractTextPlugin = require('./app-webpack/node_modules/extract-text-webpack-plugin');

const NODE_ENV = process.env.NODE_ENV || 'dev';

module.exports = {
    entry: {
        index: './js/index',
        shop: './js/shop'
        // ,
        // main: './css/style',
        // magnified: './css/magnified',
        // animate: './css/animate'
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'assets')
    },
    // module: {
    //     loaders: [
    //         {
    //             test: /\.css$/,
    //             loader: ExtractTextPlugin.extract(
    //                 {
    //                     fallback: './app-webpack/node_modules/style-loader',
    //                     use: './app-webpack/node_modules/css-loader'
    //                 }
    //             )
    //         },
    //         {
    //             test: /\.(png|jpg|gif|svg|eot|ttf|woff|woff2)$/,
    //             loader: './app-webpack/node_modules/file-loader'
    //         }
    //     ]
    // },
    plugins: [
    //     new ExtractTextPlugin(
    //         {
    //             filename: 'main.css',
    //             disable: false,
    //             allChunks: true
    //         }
    //     )
    ],
    watch: NODE_ENV == 'dev',
    devtool: NODE_ENV == 'dev' ? 'source-map' : false,
    resolve: {
        modules: ['app-webpack/node_modules']
    }
};

if (NODE_ENV == 'prod') {
    module.exports.plugins.push(
        new webpack.optimize.UglifyJsPlugin({
            sourcemap: true,
            beautify: false,
            compress: {
                warnings: false,
                drop_console: true,
                unsafe: true,
            }
        })
    );
}