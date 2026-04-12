import { defineConfig } from "vite";
import { svelte } from "@sveltejs/vite-plugin-svelte";
import path from 'path'
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    envPrefix: ['VITE_', 'CAST_'],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
        svelte(),
        VitePWA({
            outDir: 'public',
            registerType: 'autoUpdate',
            injectRegister: 'auto',
            manifest: {
                name: 'Rede Akiba',
                short_name: 'Akiba',
                description: 'Leva a Akiba pra qualquer lugar! Instala o app PWA e acessa rapidinho pelo celular ou PC fácil, leve e com tudo que o otaku ama!',
                theme_color: '#0091ff',
                background_color: '#00061a',
                display: 'standalone',
                start_url: '/',
                icons: [
                    {
                        src: '/img/pwa/192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: '/img/pwa/512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    },
                    {
                        src: '/img/pwa/512.png',
                        sizes: '512x512',
                        type: 'image/png',
                        purpose: 'any maskable'
                    }
                ]
            }
        })
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        return 'vendor';
                    }
                }
            }
        }
    }
});
