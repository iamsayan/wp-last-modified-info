// node module that let's us do file system stuffs...
const path = require('path');

// Webpack expects an exported object with all the configurations, so we export an object here
module.exports = {
    entry: './index.js', // Where to find our main js
    output: {
        // where we want our built file to go to and be named
        // I name it index.build.js so I keep index files separate
        filename: 'sidebar.js',
        // we're going to put our built file in a './build/' folder
        path: path.resolve(__dirname, 'admin/assets/js')
    }, 
    watch: true,
    module: {
        rules: [
            { 
                // basically tells webpack to use babel with the correct presets
                test: /\.js$/,
                loader: 'babel-loader',
                query: {
                    presets: ['@babel/preset-env', '@babel/preset-react']
                }
            }
        ]
    },
    // Webpack yells at you if you don't choose a mode...
    mode: 'development'
}