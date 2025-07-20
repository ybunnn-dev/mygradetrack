import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', 'sans-serif'],
            },
            colors: {
                navgreen: '#129990',
                mainback: '#E1E7ED',
                f7: "#f7f7f7",
                greenactive: "#148079",
                text_semi: "#566A7F",
                text_heavy: "#1C274C",
                text_light: "#697A8D",
                for_magna: "#578FCA",
            },
            // --- Add the keyframes and animation here ---
            keyframes: {
                spin: {
                    '0%': { transform: 'rotate(0deg)' },
                    '100%': { transform: 'rotate(360deg)' },
                }
            },
            animation: {
                spin: 'spin 1s linear infinite',
            }
            // ------------------------------------------
        },
    },

    plugins: [forms, typography],
};