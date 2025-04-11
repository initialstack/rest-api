import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import fs from 'fs';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/jsx/app.jsx'],
            refresh: true,
        }),
        tailwindcss(),
        react(),
    ],
    server: {
        https: {
            key: fs.readFileSync(
                path.resolve(__dirname, './certs/localhost-key.pem')
            ),
            cert: fs.readFileSync(
                path.resolve(__dirname, './certs/localhost.pem')
            ),
        },
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        cors: {
            origin: 'https://localhost',
            credentials: true,
        },
        hmr: {
            host: 'localhost',
        },
    },
});
