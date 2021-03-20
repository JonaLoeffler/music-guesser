module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
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
