// import
import {User} from '@/types/schemas';
// export 他
export * from './schemas';

// ページ共有 引数(共通): HandleInertiaRequestsの ところ
export type PageShares = {
    auth: {
        user: User,
    }
}

// ページ引数(共通) TODO: composition api で ジェネリクス型「<T>」のところ 使えないwおい
export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

// ページネーション(Laravel)のリンク型
export type PaginationLink = {
    url: string | null, // リンクへのURL
    label: string, // 画面表示名
    active: boolean, // true:現在表示中のページ番号 / false:それ以外(戻る進むなど)
}

// ページネーション(Laravel) 型
export type Pagination<DATA extends Record<string, unknown> = Record<string, unknown>> = {
    current_page: number // 現在の表示ページ番号
    from: number // 現在の開始位置(表示する一覧内容の中で何番目から)
    to: number // 現在の終了位置(表示する一覧内容の中で何番目まで)
    data: Array<DATA> // ページングする一覧表示内容
    links: Array<PaginationLink> // ページネーションリンク型
    per_page: number // 1ページ表示数(分母)
    total: number // トータル
}
