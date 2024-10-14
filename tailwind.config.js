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

            colors: {
                'pink': {
                    100: '#f5a3c3',  // Light pink
                    200: '#f07a9b',  // Medium pink
                    300: '#f00069',  // Hover (keeping as is)
                    400: '#dd0069',  // Default (keeping as is)
                    500: '#b9005f',  // Darker pink
                    600: '#9b0055',  // Deep pink
                    700: '#730041',  // Darker tone
                },
            },
        },
    },

    darkMode: false,

    plugins: [forms],
};
