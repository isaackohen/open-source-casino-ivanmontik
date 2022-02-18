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
          ...defaultTheme.fontSize,
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/aspect-ratio'), require('@tailwindcss/typography'), require('@tailwindcss/line-clamp')],
};
