/* import inertia */
import { Head } from '@inertiajs/react';
/* import layout */
import Layout from './Layouts/BusinessSettingsLayout';
/* import 部品 */
import { Card } from '@/Components';
import { StaffForm } from './Partials';
/* import type */
import { PageProps as BasePageProps, Staff } from '@/types';

// type定義
type PageProps = BasePageProps & { staff: Staff }

/**
 * 事業所 従業員 登録画面
 */
export default function CreateStaff({ auth: {user}, staff }: PageProps) {
    return (
        <Layout user={user}>
            <Head title="事業所 設定 従業員 登録" />
            {/* メインコンテンツ */}
            <div className='w-full'>
                {/* 従業員 登録フォーム */}
                <Card className="w-full" title="従業員 登録">
                    <StaffForm staff={staff} />
                </Card>
            </div>
        </Layout>
    );
}
