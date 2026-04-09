import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    DEFAULT: '#00875a',
                    50: '#e6f7f0',
                    100: '#b3e6d1',
                    200: '#80d5b3',
                    300: '#4dc494',
                    400: '#26b87d',
                    500: '#00875a',
                    600: '#007a52',
                    700: '#006644',
                    800: '#005236',
                    900: '#003d28',
                },
            },
        },
    },

    plugins: [forms],
};
