/* import inertia */
import { Head, Link } from '@inertiajs/react';
/* import layout */
import { BusinessAuthenticatedLayout as Layout } from '@/Layouts';
/* import 部品 */
import { Card, GTIcon, Section } from '@/Components';
/* import type */
import { PageProps } from '@/types';

/**
 * 事業所 設定画面 TOP
 */
export default function BusinessSettings({ auth: {user} }: PageProps) {
    const active = route().current('business.settings.*');

    return (
        <Layout user={user} title="事業所 設定 プロフィール">
            <Head title="事業所 設定" />
            {/* メインコンテンツ */}
            <div className="py-12">
                <Section className="mb-4">
                    {/* TODO:左右の形 レイアウト 共通化 */}
                    <div className='flex flex-nowrap justify-between'>
                        {/* 左メニュー */}
                        <div className='w-1/5'>
                            {/* メニューラッパー */}
                            <ul className='box-border rounded-sm border border-gray-200 bg-gray-200 text-gray-600 w-full'>
                                <li className='bg-white font-bold overflow-hidden overflow-ellipsis whitespace-nowrap'>
                                    <Link className={['flex py-4 px-6', (active && 'text-red-700')].join(' ')} href={route('business.show')}>
                                        <div className='flex justify-between items-center'>
                                            <span>基本情報</span>
                                            <span className='text-gray-400'><GTIcon className='h-4 w-4'/></span>
                                        </div>
                                    </Link>
                                </li>
                                <li className='hover:bg-gray-100 overflow-ellipsis whitespace-nowrap py-4 px-6'>従業員</li>
                                <li className='hover:bg-gray-100 overflow-ellipsis whitespace-nowrap py-4 px-6'>従業員</li>
                            </ul>
                        </div>
                        {/* 右コンテンツ */}
                        <div className="w-4/5 ml-4">
                            <Card className="w-full" title="基本情報">
                                <div></div>
                                <div>内容</div>
                            </Card>
                        </div>
                    </div>
                </Section>
            </div>
        </Layout>
    );
}
