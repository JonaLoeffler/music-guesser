const colors = require('tailwindcss/colors')

module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      black: colors.black,
      gray: colors.gray,
      white: colors.white,
      indigo: colors.indigo,
      pink: {
        400: '#cb8099'
      },
      green: {
        100: '#eefbf0',
        200: '#def7e2',
        800: '#25844e',
      }
    },
    minHeight: {
      '5/6': '66.66666vh',
      'screen': '100vh',
    },
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
