/** @type {import('tailwindcss').Config} */
import colors from 'tailwindcss/colors';
import animationDelay from 'tailwindcss-animation-delay';

export default {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            screens: {
                xs: '470px',
                mobile: '420px',
            },
            fontFamily: {
                lora: ['Lora'],
                nabla: ['Nabla'],
            },
            fontSize: {
                xsm: '13px',
                '2xs': '11px',
                xxs: '10px',
            },
            colors: {
                'dark-bg': '#060818',
                'dark-color': 'rgba(255, 255, 255, 0.87)',
                'light-bg': '#ffffff',
                'light-color': '#213547',
                active: {
                    // DEFAULT: '#E2C537',
                    DEFAULT: colors.emerald[500],
                    light: colors.emerald[700],
                    dark: colors.emerald[500],
                    hover: colors.emerald[200],
                },
                'cc-12': '#1b2e4b',
                'cc-18': '#191e3a',
                'cc-10': '#0e1726',
                'cc-13': '#25d5e4',
                'cc-14': '#009688',
                'cc-19': '#060818',
                'cc-20': '#1a1c2d',
                'cc-21': '#3b3f5c',
            },
            transitionProperty: {
                width: 'width',
                height: 'height',
                'max-height': 'max-height',
            },
            boxShadow: {
                google: '0px 8px 10px 1px rgba(0, 0, 0, 0.14), 0px 3px 14px 2px rgba(0, 0, 0, 0.12), 0px 5px 5px -3px rgba(0, 0, 0, 0.2)',
                'google-sm':
                    '0px 2px 2px 1px rgba(0, 0, 0, 0.14), 0px 2px 2px 2px rgba(0, 0, 0, 0.12), 0px 2px 2px 0px rgba(0, 0, 0, 0.2)',

                'google-dark':
                    '0px 8px 10px 1px rgba(14, 16, 9, 0.86), 0px 3px 14px 2px rgba(14, 16, 9, 0.88), 0px 5px 5px -3px rgba(14, 16, 9, 0.8)',
            },
            borderRadius: {
                sm: '4px',
            },
            animationDelay: {
                100: '100ms',
                200: '200ms',
                300: '300ms',
                400: '400ms',
                500: '500ms',
                600: '600ms',
                700: '700ms',
                800: '800ms',
                900: '900ms',
                1000: '1000ms',
                1100: '1100ms',
                1200: '1200ms',
                1300: '1300ms',
                1400: '1400ms',
                1500: '1500ms',
                1600: '1600ms',
            },
        },
    },
    plugins: [animationDelay],
};
