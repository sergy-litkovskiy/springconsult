'use strict';

var path = require('path');
var webpack = require('./app-webpack/node_modules/webpack');

const NODE_ENV = process.env.NODE_ENV || 'dev';

module.exports = {
    entry: {
        index: './js/index.js',
        shop: './js/shop.js'
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'js/map')
    },
    watch: NODE_ENV == 'dev',
    devtool: NODE_ENV == 'dev' ? 'source-map' : false,

    plugins: [
        // new webpack.DefinePlugin({
        //     NODE_ENV: JSON.stringify(NODE_ENV)
        // })
    ]
    ,
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