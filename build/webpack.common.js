const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const isDev = process.env.NODE_ENV === 'development';

module.exports = {
    entry: {
        'form-component': [
            '@babel/polyfill',
            path.resolve(__dirname, '../src/js/form-component.js')
        ],
    },
    output: {
        path: path.resolve(__dirname, '../assets'),
        filename: 'js/[name].min.js'
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                resolve: {extensions: [".js", ".jsx"]},
                loader: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            '@babel/preset-env'
                        ]
                    }
                },
                exclude: /node_modules/
            },
            {
                test: /\.(sass|scss)$/,
                include: path.resolve(__dirname, '../src/scss'),
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            hmr: isDev,
                            sourceMap: isDev,
                        },
                    },
                    {
                        loader: "css-loader",
                        options: {
                            sourceMap: isDev,
                            url: false
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: () => [
                                require('autoprefixer')
                            ],
                            sourceMap: isDev
                        }
                    },
                    {
                        loader: "sass-loader",
                        options: {
                            sourceMap: isDev,
                        }
                    }

                ],
            },
            {
                test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'fonts'
                    }
                }]
            },
        ]
    },
    plugins: [
    	new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: 'css/[name].min.css',
        }),
    ],
    watchOptions: {
        poll: true,
        aggregateTimeout: 100
    },
    performance: {
        hints: false
    },
    externals: {
        $: 'jQuery',
        jQuery: 'jQuery',
    },
};