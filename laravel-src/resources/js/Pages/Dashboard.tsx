/* import inertia */
import { Head } from '@inertiajs/react';
/* import layout */
import { AuthenticatedLayout as Layout } from '@/Layouts';
/* import 部品 */
import { Section } from '@/Components'
import { SelectAuthBusiness } from '@/Pages/AuthBusiness/Partials'
/* import type */
import { PageProps } from '@/types';

/**
 * @returns ログイン後 TOP画面
 */
export default function Dashboard({ auth }: PageProps) {
    // ダッシュボード画面
    return (
        // 認証後 画面のレイアウト表示 TODO:事業所選択後は別にする TODO:左ロゴ、右メニュー 以外いる？
        <Layout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">操作する事業所 選択</h2>}
        >
            <Head title="ダッシュボード" />
            <div className="py-12">
                {/* 事業所 選択 */}
                <Section>
                    <SelectAuthBusiness />
                </Section>
            </div>
        </Layout>
    );
}
