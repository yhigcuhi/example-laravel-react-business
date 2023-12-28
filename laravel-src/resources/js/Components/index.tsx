/* 部品集約 TODO:breezeの部品をその後 */
/* import react */
import React, { PropsWithChildren, ReactNode } from 'react';
/* アイコンファイル */
export * from './icons';
/* 集約するやつ(breeze産) */
import ApplicationLogo from './ApplicationLogo'
import NavLink from './NavLink';
import ResponsiveNavLink from './ResponsiveNavLink';

// 内部利用関数
const join = (classNames: string[] = []) => classNames.join(' ')

/* export breeze産 */
export {
    ApplicationLogo,
    NavLink,
    ResponsiveNavLink,
}

/* export 独自作成部品 */
// メインコンテンツ内 基本 セクション
export const Section = ({children, ...props}: PropsWithChildren) => (
    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8" {...props}>{children}</div>
);

// カード形式
export const Card = ({children, className = '', title, subTitle, header, ...props}: PropsWithChildren<React.AreaHTMLAttributes<HTMLDivElement> & {title?: string, subTitle?: string, header?: ReactNode}>) => (
    // カード Wrapper
    <div className={join(['p-4 sm:p-8 bg-white shadow sm:rounded-lg', className])} {...props}>
        <section>
            {/* カードヘッダー */}
            {
                title
                // タイトル文字存在時
                ? (<CardHeader title={title} subTitle={subTitle}></CardHeader>)
                // その他 ヘッダー要素で描画
                : (<header>{header}</header>)
            }
            {/* カードボディ */}
            {children}
        </section>
    </div>
)
// ベース カードヘッダー
const CardHeader = ({title, subTitle}: {title: string, subTitle?: string}) => (
    <header>
        {/* 主題 */}
        <h2 className="text-lg font-medium text-gray-900">{ title }</h2>
        {/* 副題 */}
        ( subTitle ? (<p className="mt-1 text-sm text-gray-600" v-if="subTitle">{subTitle}</p>) : null)
    </header>
)

// テーブル
export const Table = ({children, className = '', header, headerClassName = '', ...props}: PropsWithChildren<React.AreaHTMLAttributes<HTMLTableElement> & {header?: ReactNode, headerClassName?: string}>) => (
    <table className={join(['w-full table text-left bg-white', className])} {...props}>
        {/* テーブルヘッダー */}
        <thead className={headerClassName}>
            {header}
        </thead>
        {/* テーブルメイン */}
        <tbody>
            {children}
        </tbody>
    </table>
)
// 基本的な 標題
export const TH = ({children, className = '', ...props}: PropsWithChildren<React.AreaHTMLAttributes<HTMLTableCellElement>>) => (
    <th className={join(['p-4 font-bold', className])} {...props}>{children}</th>
)
// 基本的な セル
export const TD = ({children, className = '', ...props}: PropsWithChildren<React.AreaHTMLAttributes<HTMLTableCellElement>>) => (
    <td className={join(['p-4 text-gray-600', className])} {...props}>{children}</td>
)
