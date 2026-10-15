import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class', // <-- Ditambahkan di sini
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#0F3D3E',
        secondary: '#D6C3A3',
        light: '#F2F3F7',
        grayAlt: '#D9D9D9',
      },
    },
  },
  plugins: [],
}