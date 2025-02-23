/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "**/*.{vue,js,ts,jsx,tsx}",
    "**/*.{html,html.twig}",
    "../../../vendor/morgenbord/core-bundle/templates",
    "../../../vendor/morgenbord/checklist-widget-bundle/templates",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    // require("daisyui")
  ],
}