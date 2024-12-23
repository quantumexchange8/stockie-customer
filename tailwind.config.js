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
                sans: ['Lexend', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'pointbg': "url('/assets/image/pointbg.svg')",
                'keepbg': "url('/assets/image/keepbg.svg')",
            },
            fontSize: {
                'xss': ['10px', {
                    letterSpacing: '-0.2px',
                }],
                'xs': ['12px', {
                    letterSpacing: '-0.24px',
                }],
                'sm': ['14px', {
                    letterSpacing: '-0.28px',
                }],
                'base': ['16px', {
                    letterSpacing: '-0.32px',
                }],
                'xl': ['20px', {
                    letterSpacing: '-0.4px',
                }],
                '2xl': ['24px', {
                    letterSpacing: '-0.48px',
                }],
                '3xl': ['30px', {
                    letterSpacing: '-0.6px',
                }],
            },
            colors: {
                'primary': {
                    25: 'var(--primary-25)',
                    50: 'var(--primary-50)',
                    100: 'var(--primary-100)',
                    200: 'var(--primary-200)',
                    300: 'var(--primary-300)',
                    400: 'var(--primary-400)',
                    500: 'var(--primary-500)',
                    600: 'var(--primary-600)',
                    700: 'var(--primary-700)',
                    800: 'var(--primary-800)',
                    900: 'var(--primary-900)',
                    950: 'var(--primary-950)',
                },
                gray: {
                    25: '#fcfcfc',
                    50: '#f8f9fa',
                    100: '#eceff2',
                    200: '#d6dce1',
                    300: '#b2bec7',
                    400: '#889ba8',
                    500: '#697e8e',
                    600: '#546775',
                    700: '#45535f',
                    800: '#3c4750',
                    900: '#353d45',
                    950: '#23292e',
                },
                warning: {
                    25: '#fffcf9',
                    50: '#fdf6ef',
                    100: '#fbead9',
                    200: '#f6d1b2',
                    300: '#f0b281',
                    400: '#e9894e',
                    500: '#e46a2b',
                    600: '#d55121',
                    700: '#b13e1d',
                    800: '#8d321f',
                    900: '#732c1c',
                    950: '#3d140d',
                },
                blue: {
                    50: '#f0f7ff',
                    100: '#e0edfe',
                    200: '#b9dbfe',
                    300: '#7cbefd',
                    400: '#369ffa',
                    500: '#0c82eb',
                    600: '#005dba',
                    700: '#014fa3',
                    800: '#064586',
                    900: '#0b3a6f',
                    950: '#07244a',
                },
                success: {
                    50: '#f0fbea',
                    100: '#ddf5d2',
                    200: '#bcecaa',
                    300: '#93de78',
                    400: '#6dcd4e',
                    500: '#46a12b',
                    600: '#388e22',
                    700: '#2d6d1e',
                    800: '#28571d',
                    900: '#244a1d',
                    950: '#0f280b',
                },
            }
        },
    },

    plugins: [forms],
};
