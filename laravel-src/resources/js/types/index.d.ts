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
