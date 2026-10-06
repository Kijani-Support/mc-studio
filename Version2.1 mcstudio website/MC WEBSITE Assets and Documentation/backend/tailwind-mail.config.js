const defaultTheme = require('tailwindcss/defaultTheme');
 
module.exports = {
    content: [
        './resources/views/emails/**/*.blade.php',
    ],
    theme: {
        screens: {
            'xxs': '375px',
            'xs': '475px',
            ...defaultTheme.screens,
        },
        extend: {
        },
    },
    plugins: [],
}