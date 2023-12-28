/** import vite */
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    // 利用プラグイン一覧
    plugins: [
        laravel({
            input: 'resources/js/app.tsx',
            refresh: true,
        }),
        react(),
    ],
    // 開発サーバー設定
    server: {
        // docker コンテナで起動された 5173へのアクセスとか
        host: true,
    }
});
