/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        body: "#F5F7FA", 
        primary: "#42b883",
        hover_menu: "#EFF2F6",
        black_500: "#141824",
        current: '#42b883',
        last: '#82ca9d',
        view: '#D9FBD0',
        head: "#2b3445",
      },
      fontSize :{
        ph: '13px'
      },
      transitionDuration: {
        '0': '0ms',
      },
    },
  },
  plugins: [
    require('tailwind-scrollbar')({ nocompatible: true }),
    require("@tailwindcss/forms"),
  ],
}

