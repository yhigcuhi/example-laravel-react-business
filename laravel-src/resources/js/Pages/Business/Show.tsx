/* import inertia */
import { Head } from '@inertiajs/react';
/* import layout */
import { BusinessAuthenticatedLayout as Layout } from '@/Layouts';
/* import type */
import { PageProps } from '@/types';

/**
 * 事業所 Top
 */
export default function BusinessShow({ auth: {user} }: PageProps) {
    return (
        <Layout user={user}>
            <Head title="事業所 詳細" />
            {/* TODO:今後メインコンテンツ */}
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">最終的には打刻画面にする!</div>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
