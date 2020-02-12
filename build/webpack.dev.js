const merge = require('webpack-merge');
const common = require('./webpack.common.js');
const path = require('path');

module.exports = merge(common, {
    mode: 'development',
    watch: true,
    devtool: '#source-map',
    optimization: {
        minimize: false
    },
    devServer: {
        contentBase: path.resolve(__dirname, '../assets'),
        port: 7700,
        publicPath: '/',
        stats: "minimal",
        watchContentBase: true,
        historyApiFallback: true,
        open: false,
        hot: false
    }
});