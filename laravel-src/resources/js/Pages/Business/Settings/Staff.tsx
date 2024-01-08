/* import inertia */
import { Head } from '@inertiajs/react';
/* import lodash */
import { map } from 'lodash'
/* import layout */
import Layout from './Layouts/BusinessSettingsLayout';
/* import 部品 */
import { Card, AppendButton, Table, TH, TD, Paginator, EditButton } from '@/Components';
/* import type */
import { PageProps as BasePageProps, Pagination, Staff } from '@/types';

// type定義
type PageProps = BasePageProps & { staff: Pagination<Staff> }

// 表ヘッダー
const THead = ({className = ''}) => (
    <tr className={className}>
        <TH className='w-2/12'>コードとか?</TH>
        <TH className='w-6/12'>名前 (部署とかTODO)</TH>
        <TH className='w-4/12'>
            <div className='flex justify-end'>
                <AppendButton href={route('business.settings.staff.create')}>追加</AppendButton>
            </div>
        </TH>
    </tr>
)
/**
 * 事業所 従業員 設定画面 TOP
 */
export default function StaffList({ auth: {user}, staff }: PageProps) {
    return (
        <Layout user={user}>
            <Head title="事業所 設定 従業員" />
            {/* メインコンテンツ */}
            <div className='w-full'>
                {/* 従業員 一覧 */}
                <Card className="w-full" title="従業員 管理">
                    {/* TODO: 招待フォーム → 招待アカウント登録画面 の順で作成 */}
                    {/* 一覧表 */}
                    <Table className="my-6 border border-gray-200" header={<THead />} headerClassName='bg-gray-200'>
                        {/* 一覧表: ボディ */}
                        {
                            map(staff.data, ({id, name, kana}) => {
                                // 画面描画
                                return (
                                    // 各行 表示
                                    <tr key={id} className="border-b hover:bg-gray-100">
                                        <TH>{id}</TH>
                                        <TH>{`${name} (${kana})`}</TH>
                                        <TD className='flex justify-end items-center gap-4'>
                                            <EditButton href={route('business.settings.staff.edit', {id})} />
                                        </TD>
                                    </tr>
                                )
                            })
                        }
                    </Table>
                </Card>
                {/* ページャー */}
                <Paginator pagination={staff} />
            </div>
        </Layout>
    );
}
