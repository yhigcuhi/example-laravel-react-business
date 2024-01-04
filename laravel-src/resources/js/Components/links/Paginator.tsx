/* import react */
import { AreaHTMLAttributes } from 'react'
/* import lodash */
import { map } from 'lodash'
/* import inertia */
import { Link } from '@inertiajs/react'
/* import type */
import { Pagination, PaginationLink } from '@/types'

// 現在表示中のリンク
const ActiveLink = ({link, ...props}: {link: PaginationLink}) => (
    <span {...props}>
        <span
            className="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-blue-500 px-4 py-2 text-lg font-medium leading-5 text-gray-100"
            dangerouslySetInnerHTML={{
                __html: link.label,
            }}
        ></span>
    </span>
)
// 非活性リンク
const NonActiveLink = ({link, ...props}: {link: PaginationLink}) => (
    <span {...props}>
        <span
            className="relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-300"
            dangerouslySetInnerHTML={{
                __html: link.label,
            }}
        ></span>
    </span>
)
// その他 通常ページリンク
const PageLink = ({link, ...props}: {link: PaginationLink}) => (
    <span {...props}>
        <Link
            href={link.url ?? ''}
            preserveState={true}
            className="relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 hover:bg-gray-300"
            dangerouslySetInnerHTML={{
                __html: link.label,
            }}
        ></Link>
    </span>
)
/**
 * @returns ページャー
 */
export default function Paginator({pagination, className = ''}: AreaHTMLAttributes<HTMLDivElement> & { pagination: Pagination }) {
    // リンク情報外だしs
    const { links } = pagination
    // ページネーションリンク
    return (
        // wrapper
        <div className={['my-2 sm:flex sm:flex-1 sm:items-center sm:justify-between', className].join(' ')}>
            {/* 現在の情報 */}
            <p className="text-sm leading-5 text-gray-700 font-medium">
                <span>{pagination.total}件中</span>
                <span className="mx-2">...</span>
                <span>
                    {pagination.from}/{pagination.to} 表示
                </span>
            </p>
            {/* ナビゲーションリンク */}
            <div>
                <span className="relative z-0 inline-flex rounded-md shadow-sm">
                    <span>
                        {/* 各リンク描画 */}
                        {map(links, (link, index) => {
                            // アイテムキー
                            const key = link.label + index
                            // アクティブリンクの場合
                            if (link.active) return (<ActiveLink key={key} link={link} />)
                            // リンクのURLなしの場合
                            if (link.url === null) return (<NonActiveLink key={key} link={link} />)
                            // その他 通常 ページリンク
                            return (<PageLink key={key} link={link} />)
                        })}
                    </span>
                </span>
            </div>
        </div>
    )
}
