import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            'primary-50': '#fffdf5',
            'primary-100': '#fff7d6',
            'primary-200': '#ffefad',
            'primary-300': '#ffe885',
            'primary-400': '#ffe05c',
            'primary-500': '#ffd833',
            'primary-600': '#ccad29',
            'primary-700': '#99821f',
            'primary-800': '#665614',
            'primary-900': '#332b0a',
            'secondary-50': '#f4f5f5',
            'secondary-100': '#d5d5d6',
            'secondary-200': '#abacad',
            'secondary-300': '#808285',
            'secondary-400': '#56595c',
            'secondary-500': '#2c2f33',
            'secondary-600': '#232629',
            'secondary-700': '#1a1c1f',
            'secondary-800': '#121314',
            'secondary-900': '#09090a',
            'red': '#A31616',
            'green': '#16A34A',
            'blue': '#163DA3',
            'black': '#000000',
            'white': '#ffffff',
        },
    },

    plugins: [forms],
};
