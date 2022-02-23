const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/**/*.vue',
        './resources/js/**/**/**/*.vue',
        './resources/js/**/**/**/**/*.vue',
    ],

    theme: {
        screens: {
          'xxs': '250px',
          'xs': '425px',
          ...defaultTheme.screens,
        },
        fontSize: {
          'xxs': '.65rem',
          'tab': ['14px', '1'],
          'subheader': ['17px', '1.7'],
          'base': ['15px', '1.7'],
          'lg': ['18px', '1.7'],
                ...defaultTheme.fontSize,
        },
    fontWeight: {
          'hairline': 100,
          'extra-light': 100,
          'thin': 200,
          'light': 300,
          'normal': 400,
          'medium': 500,
          'semibold': 600,
          'bold': 700,
          'extrabold': 800,
          'extra-bold': 800,
          'black': 900,
        },
        extend: {
            fontFamily: {
                sans: ['Ubuntu', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/aspect-ratio'), require('@tailwindcss/typography'), require('@tailwindcss/line-clamp')],
};
 