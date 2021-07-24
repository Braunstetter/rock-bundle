const colors = require('tailwindcss/colors')

module.exports = {
  purge: ['./src/Resources/views/**/*.{twig, html.twig}'],
  darkMode: 'media',
  mode: 'jit',
  theme: {
    extend: {
      colors: {
        gray: colors.trueGray,
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
