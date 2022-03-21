// let tailwindcss = require('tailwindcss');

module.exports = {
    plugins: [
        require('postcss-import'),
        require('tailwindcss')('./assets/tailwind.config.js'),
        // tailwindcss('./assets/tailwind.config.js'), // your tailwind.js configuration file path
        require('autoprefixer'),
    ]
}
