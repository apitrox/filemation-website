/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.html",
    "./js/*.js"
  ],
  theme: {
    extend: {
      colors: {
        'filemation-green': '#59ab37',
        'filemation-green-light': '#3eae49',
        'filemation-green-dark': '#537c43',
        'filemation-green-accent': '#2dc997',
        'filemation-green-hover': '#51d8ad',
        'filemation-blue': '#527493',
        'filemation-gray': '#666666',
      },
      fontFamily: {
        'sans': ['Open Sans', 'sans-serif'],
        'heading': ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
