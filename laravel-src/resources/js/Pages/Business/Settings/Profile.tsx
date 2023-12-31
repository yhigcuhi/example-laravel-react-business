/* import inertia */
import { Head } from '@inertiajs/react';
/* import layout */
import Layout from './Layouts/BusinessSettingsLayout';
/* import 部品 */
import { Card } from '@/Components';
import { UpdateBusinessProfileForm } from './Partials';
/* import type */
import { PageProps } from '@/types';

/**
 * 事業所 設定画面 TOP
 */
export default function BusinessSettings({ auth: {user} }: PageProps) {
    return (
        <Layout user={user}>
            <Head title="事業所 設定 プロフィール" />
            {/* メインコンテンツ */}
            <Card className="w-full" title="基本情報 編集">
                {user.operating_business?.business && <UpdateBusinessProfileForm business={user.operating_business.business} />}
            </Card>
        </Layout>
    );
}
