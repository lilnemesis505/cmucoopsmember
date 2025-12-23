import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'; // <--- สำคัญ: ต้องมีบรรทัดนี้

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
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
    // เพิ่มส่วนนี้เพื่อให้ใช้ @ แทน resources/js ได้
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
    server: {
        host: '0.0.0.0', // เปิดรับทุก IP
        hmr: {
            host: '172.16.22.131' // ⚠️ ใส่ IP ของเครื่องคุณ (ที่เช็คจาก ipconfig)
        },
        port: 8000, // ล็อคเลข Port ไว้จะได้ไม่ต้องแก้ Firewall บ่อย
    },
});