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
            canvas: '#FAFAF8',
            border: '#E7E4DD',

            accent: {
                DEFAULT: '#3D6B99',
                hover: '#345A81',
                tint: '#EAF1F7',
            },

            status: {
                open: '#3D6B99',
                progress: '#C08A2E',
                resolved: '#4F9A78',
                closed: '#94A3A8',
                reopened: '#C1495A',
            },
        },
        },
    },

    plugins: [forms],
};
