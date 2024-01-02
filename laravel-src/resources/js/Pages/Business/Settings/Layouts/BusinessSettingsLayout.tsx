/* import react */
import { AreaHTMLAttributes, PropsWithChildren } from 'react';
/* import inertia */
import { Head } from '@inertiajs/react';
/* import layout */
import { BusinessAuthenticatedLayout as Layout, BaseSettingsLayout as SettingsLayout } from '@/Layouts';
/* import 部品 */
import { Section } from '@/Components';
/* import types */
import { User } from '@/types';

// 事業所 設定画面 メニュー一覧
const MENUS = [
    {
        name: '基本情報', // 画面表示 メニュー名
        href: route('business.settings.profile'), // リンク
        active: () => route().current('business.settings.profile'), // URLアクティブ条件
    },
    {
        name: '従業員 管理', // 画面表示 メニュー名
        href: route('business.settings.staff.index'), // リンク
        active: () => route().current('business.settings.staff.*'), // URLアクティブ条件
    },
]

/**
 * 事業所 設定画面 レイアウト
 */
export default function BusinessSettings({ user, children }: PropsWithChildren<AreaHTMLAttributes<HTMLDivElement>> & { user: User }) {
    return (
        <Layout user={user} title="事業所 設定">
            <Head title="事業所 設定" />
            {/* メインコンテンツ */}
            <div className="py-12">
                <Section className="mb-4">
                    {/*　設定画面レイアウト */}
                    <SettingsLayout menus={MENUS}>
                        {children}
                    </SettingsLayout>
                </Section>
            </div>
        </Layout>
    );
}
