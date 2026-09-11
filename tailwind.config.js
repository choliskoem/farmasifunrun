/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    "Plus Jakarta Sans",
                    "Inter",
                    "ui-sans-serif",
                    "system-ui",
                    "sans-serif",
                ],
            },

            colors: {
                himafa: {
                    50: "#ecfdf5",
                    100: "#d1fae5",
                    200: "#a7f3d0",
                    300: "#6ee7b7",
                    400: "#34d399",
                    500: "#10b981",
                    600: "#059669",
                    700: "#047857",
                    800: "#065f46",
                    900: "#064e3b",
                },
            },

            boxShadow: {
                soft: "0 20px 60px rgba(15, 118, 110, 0.10)",
                card: "0 10px 40px rgba(15, 23, 42, 0.07)",
            },

            animation: {
                "float-slow": "float 6s ease-in-out infinite",
                "float": "float 4s ease-in-out infinite",
                "fade-up": "fadeUp .8s ease-out both",
            },

            keyframes: {
                float: {
                    "0%, 100%": {
                        transform: "translateY(0)",
                    },
                    "50%": {
                        transform: "translateY(-15px)",
                    },
                },

                fadeUp: {
                    "0%": {
                        opacity: "0",
                        transform: "translateY(30px)",
                    },
                    "100%": {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                },
            },
        },
    },

    plugins: [],
};