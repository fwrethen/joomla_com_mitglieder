const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
    entry: {
        index: ['./media/com_mitglieder/css/index.scss']
    },
    mode: 'production',
    output: {
        path: path.resolve(__dirname, 'build/media/com_mitglieder/js'),
        filename: 'com_mitglieder.js'
    },

    module: {
        rules: [
            {
                test: /\.(scss)$/,
                use: [{
                    loader: MiniCssExtractPlugin.loader
                }, {
                    loader: 'css-loader'
                }, {
                    loader: 'postcss-loader',
                    options: {
                        postcssOptions: {
                            plugins: () => [require('autoprefixer')]
                        }
                    }
                }, {
                    loader: 'sass-loader'
                }]
            }
        ]
    },

    plugins: [
        new MiniCssExtractPlugin({
            filename: '../css/com_mitglieder.css'
        })
    ]
};
