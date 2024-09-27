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
                maaxRegular: ['maax-regular', ...defaultTheme.fontFamily.sans],
                maaxBold: ['maax-bold', ...defaultTheme.fontFamily.sans],
                maaxMedium: ['maax-medium', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    darkMode: false,

    plugins: [forms],
};