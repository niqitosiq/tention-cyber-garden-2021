const path = require('path')
const fs = require("fs");
const HtmlWebpackPlugin = require("html-webpack-plugin");
const {CleanWebpackPlugin} = require("clean-webpack-plugin");
const appDirectory = fs.realpathSync(process.cwd());
module.exports = {
    mode: 'development',
    entry: './src/js.js',
    output: {
        filename: 'bundle.js',
        path: path.resolve(appDirectory, 'dist'),
    },
    devServer: {
        host: "0.0.0.0",
        port: 8081,
        disableHostCheck: true,
        contentBase: path.resolve(appDirectory, "public"), //tells webpack to serve from the public folder
        publicPath: "/",
        hot: true,
    },
    plugins: [
        new HtmlWebpackPlugin({
            inject: true,
            template: path.resolve(appDirectory, "public/index.html"),
        }),
        new CleanWebpackPlugin(),
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                enforce: 'pre',
                use: ['source-map-loader'],
            },
        ],
    }
}
