// vite.config.js (Example)
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css", // Make sure this line is present
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
});
