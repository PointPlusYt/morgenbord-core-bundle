// module.exports = {
//   content: [
//     "./templates/**/*.html.twig",
//     "./var/cache/**/*.php",
//     "./assets/bundles/**/*.vue",
//     "../**/*.html.twig",
//     // "./public/bundles/checklistwidget/Checklist.vue"
//   ],
//   darkMode: 'class',
//   theme: {
//     // colors: {
//     //   'sun-yellow': '#fede8b',
//     //   'orange': {
//     //     300: '#ff9817',
//     //     800: '#b66c2d',
//     //   },
//     //   'dark-teal': '#0f4e6f',
//     //   'dark-blue': '#002748',
//     //   'white': '#f8f2dd',
//     //   'blue-grey': '#3c6b7c',// '#3c5364',
//     //   'grey': '#7d716d',
//     //   // 'red': '#bc3512',
//     //   // 'herbs': '#3c3c1c',
//     // },
//     extend: {},
//     fontFamily: {
//       sans: ['Fira Sans', 'sans-serif'],
//       // heading: ['Fira Sans', 'sans-serif'],
//     }
//   },
//   plugins: [
//     require("@catppuccin/tailwindcss")({
//       // prefix to use, e.g. `text-pink` becomes `text-ctp-pink`.
//       // default is `false`, which means no prefix
//       // prefix: "ctp",
//       // which flavour of colours to use by default, in the `:root`
//       defaultFlavour: "macchiato",
//     }),
//   ],
// }


/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.{js,jsx,ts,tsx,vue}",
    "./templates/**/*.{html,html.twig}"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@catppuccin/tailwindcss')({
      prefix: false,
      defaultFlavour: 'mocha'
    }),
    require('@tailwindcss/forms'),
  ],
}
