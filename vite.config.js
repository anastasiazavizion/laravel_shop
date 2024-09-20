import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    server: {
        port: '5175'
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/scss/app.scss',  'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => tag.startsWith('swiper'),
                },
            },
        }),
    ],


    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
})
