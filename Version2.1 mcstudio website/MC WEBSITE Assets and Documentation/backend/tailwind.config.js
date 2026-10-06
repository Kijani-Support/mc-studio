/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors') 
const {
    toRGB,
    withOpacityValue,
} = require("@left4code/tw-starter/dist/js/tailwind-config-helper");

module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './vendor/filament/**/*.blade.php',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        danger: colors.rose,
        primary: colors.emerald,
        success: colors.blue,
        warning: colors.yellow,
        secondary: withOpacityValue("--color-secondary"),
        darkmode: {
            50: withOpacityValue("--color-darkmode-50"),
            100: withOpacityValue("--color-darkmode-100"),
            200: withOpacityValue("--color-darkmode-200"),
            300: withOpacityValue("--color-darkmode-300"),
            400: withOpacityValue("--color-darkmode-400"),
            500: withOpacityValue("--color-darkmode-500"),
            600: withOpacityValue("--color-darkmode-600"),
            700: withOpacityValue("--color-darkmode-700"),
            800: withOpacityValue("--color-darkmode-800"),
            900: withOpacityValue("--color-darkmode-900"),
        },
      }
    },
  },
  plugins: [],
}
