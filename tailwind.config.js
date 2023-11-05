import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.tsx",
    ],

    theme: {
        extend: {
            colors: {
                current: "currentColor",
                transparent: "transparent",
                white: "white",
                bg: "rgb(var(--color-bg) / <alpha-value>)",
                "bg-inverse": "rgb(var(--color-bg-inverse) / <alpha-value>)",
                "bg-hover": "rgb(var(--color-bg-hover) / <alpha-value>)",
                "bg-btn": "rgb(var(--color-bg-btn) / <alpha-value>)",
                "bg-btn-danger":
                    "rgb(var(--color-bg-btn-danger) / <alpha-value>)",
                "bg-modal-overlay":
                    "rgb(var(--color-bg-modal-overlay) / <alpha-value>)",
                text: "rgb(var(--color-text) / <alpha-value>)",
                "text-inverse":
                    "rgb(var(--color-text-inverse) / <alpha-value>)",
                "text-link": "rgb(var(--color--text-link) / <alpha-value>)",
                "text-light": "rgb(var(--color-text-light) / <alpha-value>)",
                "text-error": "rgb(var(--color-text-error) / <alpha-value>)",
                border: "rgb(var(--color-border) / <alpha-value>)",
                "border-input":
                    "rgb(var(--color-border-input) / <alpha-value>)",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            borderColor: ({ theme }) => ({
                ...theme("colors"),
                DEFAULT: theme("colors.border", "currentColor"),
            }),
        },
    },

    plugins: [forms],
};
