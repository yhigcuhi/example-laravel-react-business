/* breeze提供共通 */
import './bootstrap';
/* 静的資材読み込み */
import '../css/app.css';
/* import react */
import { createRoot } from 'react-dom/client';
/* import inertia */
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
/* import redux */
import { Provider } from 'react-redux'
import { store } from './stores'

// アプリケーション名 (envから)
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    // title属性値基本
    title: (title) => `${title} - ${appName}`,
    // laravel Inertia::render('画面パス') の画面パス → JSX資材パス 結びつけ
    resolve: (name) => resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx')),
    // 画面描画など
    setup({ el, App, props }) {
        const root = createRoot(el);
        // ReactDOM.render
        root.render(
            // reduxのコンテキスト共有
            <Provider store={store}>
                {/* アプリケーション描画 */}
                <App {...props} />
            </Provider>
        );
    },
    // プログレスバーの設定
    progress: {
        color: '#4B5563',
    },
});
