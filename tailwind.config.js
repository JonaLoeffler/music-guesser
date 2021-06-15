module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    height: {
      '50': '50rem',
      'screen': '100vh',
    },
    extend: {},
  },
  variants: {
    extend: {
      backgroundColor: ['disabled'],
      opacity: ['disabled'],
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
