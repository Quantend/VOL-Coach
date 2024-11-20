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
                arial: ['arial', ...defaultTheme.fontFamily.sans],
                poppins: ['poppins', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                'pink': {
                    100: '#F5A3C3',  // Light pink
                    200: '#F07A9B',  // Medium pink
                    300: '#F00069',  // Hover (keeping as is)
                    400: '#DD0069',  // Default (keeping as is)
                    500: '#B9005F',  // Darker pink
                    600: '#9B0055',  // Deep pink
                    700: '#730041',  // Darker tone
                    800: '#FFFFFF',  // White
                },

                'blue': {
                    100: '#A3CFF5',  // Light blue
                    200: '#7AB4F0',  // Medium blue
                    300: '#00365E',  // Hover (keeping as is)
                    400: '#00365E',  // Default (keeping as is)
                    500: '#0048B9',  // Darker blue
                    600: '#003D9B',  // Deep blue
                    700: '#002F73',  // Darker tone
                    800: '#FFFFFF',  // White
                },

                'yellow': {
                    100: '#FFF5A3',  // Light yellow
                    200: '#FFE87A',  // Medium yellow
                    300: '#F8E800',  // Hover (keeping as is)
                    400: '#F8E800',  // Default (keeping as is)
                    500: '#B9A800',  // Darker yellow
                    600: '#9B9100',  // Deep yellow
                    700: '#736B00',  // Darker tone
                    800: '#FFFFFF',  // White
                },

                'green': {
                    100: '#A3F5D2',  // Light green
                    200: '#7AF0BE',  // Medium green
                    300: '#00B588',  // Hover (keeping as is)
                    400: '#00B588',  // Default (keeping as is)
                    500: '#007F5F',  // Darker green
                    600: '#006B50',  // Deep green
                    700: '#004B3A',  // Darker tone
                    800: '#FFFFFF',  // White
                },
               
            },
            },
        },

    darkMode: false,

    plugins: [forms],
};
