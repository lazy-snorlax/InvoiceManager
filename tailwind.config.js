/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/src/**/*.{js,jsx,ts,tsx}", "./app/templates/**/*.twig"],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
};
