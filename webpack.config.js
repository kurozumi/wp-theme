const path = require("path");
const webpack =require('webpack');

module.exports = {
    mode: 'development',
    entry: path.resolve(__dirname, 'assets/webpack/app.js'),
    output: {
        path: path.resolve(__dirname, 'assets/js'),
        filename: 'bundle.js'
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            Popper: ['popper.js', 'default'], 
        })
    ]
}