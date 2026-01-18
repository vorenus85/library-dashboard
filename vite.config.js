import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwind from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        tailwind(),
    ],
    /*
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "resources/css/_variables.scss";`,
            },
        },
    },
    */
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        host: true,
        port: 5173,
        hmr: {
            host: 'localhost',
        },
    },
})
