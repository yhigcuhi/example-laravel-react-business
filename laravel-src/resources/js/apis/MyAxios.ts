/* import axios */
import Axios from 'axios'

/* 内部参照可能定数 */
// 内部アクセス可能 REST API
const INTERNAL_API_PREFIX_URL = '/api';
// 共通設定するクライアント
const myAxios = Axios.create({
    baseURL: INTERNAL_API_PREFIX_URL,
});

// 共通リクエストハンドラー設定
myAxios.interceptors.request.use(
    // 通常リクエストハンドラー
    (config) => {
        // TODO: CSRF TOKENとか
        return config;
    },
);

// 共通レスポンスハンドラー設定
myAxios.interceptors.response.use(
    // 通信成功時の共通ハンドラー
    (response) => {
        // TODO: 例えば認証成功のキーを設定するとか
        return response;
    },
    // 通信失敗時の共通ハンドラー
    (error) => {
        // エラーコード別ハンドラー
        switch (error.response.status) {
            // 特定のエラーハンドリング
            case 401: // 認証エラー
            case 500: // システムエラー
                new Error('通信エラー')
                break;
            // それ以外
            default:
                break;
        }
        // 失敗処理へ
        return Promise.reject(error);
    }
);
// export 共通クライアント
export default myAxios;

