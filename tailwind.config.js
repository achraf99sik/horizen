/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php", // Scan all Blade templates
        "./resources/**/*.js", // Scan JavaScript files
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                // Your Custom Colors (Moved from the script tag)
                "twitch-bg-dark": "#0e0e10",
                "twitch-bg-header": "#1f1f23",
                "twitch-bg-sidebar": "#18181b",
                "twitch-bg-card": "#0e0e10",
                "twitch-bg-hover": "#2f2f35",
                "twitch-purple": "#9147ff",
                "twitch-pink": "#E70353", // Used for buttons, badges
                "twitch-gray-light": "#adadb8",
                "twitch-gray-dark": "#505054",

                // Colors from your initial navbar attempt (add if needed)
                "navbar-bg": "#1f1f23", // Same as twitch-bg-header
                "brand-pink": "#ef3a83", // Similar to twitch-pink
                "brand-orange": "#e9600f",
                "search-bg": "#3a3a3d",
                "search-border": "#505054", // Same as twitch-gray-dark
            },
            fontFamily: {
                // Example if you want to apply Roboto globally via Tailwind
                sans: ["Roboto", "sans-serif"],
                // Keep Playfair Display if needed, e.g., for specific headings
                serif: ["Playfair Display", "serif"],
            },
        },
    },
    plugins: [],
};

