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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#0F766E',
                    dark: '#115E59',
                    50: '#F0FDFA',
                    100: '#CCFBF1',
                    200: '#99F6E4',
                    600: '#0D9488',
                    700: '#0F766E',
                    800: '#115E59',
                },
                accent: {
                    DEFAULT: '#F59E0B',
                    dark: '#B45309',
                    light: '#FEF3C7',
                },
                surface: '#F8FAFC',
                ink: '#0F172A',
                muted: '#64748B',
            },
            boxShadow: {
                card: '0 1px 2px rgba(15, 23, 42, 0.04), 0 8px 24px -8px rgba(15, 23, 42, 0.10)',
            },
        },
    },

    plugins: [forms],
};
