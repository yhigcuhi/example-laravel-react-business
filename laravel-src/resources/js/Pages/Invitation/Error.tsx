/* import inertia */
import { Head } from '@inertiajs/react';
/* import layout */
import { BusinessAuthenticatedLayout as Layout } from '@/Layouts';
/* import type */
import { PageProps } from '@/types';

/**
 * 招待エラーのみ 画面 TODO:今後
 */
export default function BusinessShow(param: object) {
    return (
        <div>
            <h1>TODO:エラーだけの画面表示(ゲストレイアウトで)</h1>
            {JSON.stringify(param)}
        </div>
    );
}
