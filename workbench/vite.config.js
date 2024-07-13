import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
            buildDirectory: 'build',
            // Change this to point to your workbench public directory
            publicDirectory: path.resolve(__dirname, 'workbench/public'),
            // Specify the manifest path
            manifest: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        // Specify the outDir to ensure the manifest is created in the correct location
        outDir: path.resolve(__dirname, 'workbench/public/build'),
        // Ensure the manifest is generated
        manifest: true,
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});