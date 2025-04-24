/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      './resources/views/**/*.blade.php',
      './resources/js/**/*.js',
    ],
    safelist: [
      'border-b-4',
      'border-orange-500',
    ],
    theme: {
      extend: {},
    },
    plugins: [],
  }
  