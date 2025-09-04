import vue2 from "@vitejs/plugin-vue";
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import i18n from 'laravel-vue-i18n/vite';
import manifestSRI from "vite-plugin-manifest-sri";

const config = defineConfig({
    base: '',
    plugins: [
        laravel([
            "resources/js/app.js",
            "resources/js/assets/images/favicon.png",
        ]),
        vue2(),
        i18n(),
        manifestSRI(),
    ],
    resolve: {
        alias: {
            // vue: "vue/dist/vue.esm.js",
        },
    },
    build: {
        rollupOptions: {
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`,
            },
        },
    },
    css: {
        preprocessorOptions: {
          scss: {
            additionalData: `
                @import "public/scss/abstracts/_variables.scss";
                @import "public/scss/abstracts/_placeholders.scss";
                @import "public/scss/abstracts/_functions.scss";
            `
          }
        }
    }
});

export default config;
