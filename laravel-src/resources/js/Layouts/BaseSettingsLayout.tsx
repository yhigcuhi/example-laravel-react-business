/* import react */
import { PropsWithChildren, AreaHTMLAttributes, ReactNode } from 'react';
/* import inertia */
import { Link } from '@inertiajs/react';
/* import lodash */
import { isArray, isFunction, map } from 'lodash';
/* import 部品 */
import { GTIcon } from '@/Components';

/* type 定義 */
// 左メニュー
interface MENU {
    name: string | (() => string), // 画面表示 メニュー名
    href: string | (() => string), // リンク
    active: ((currentURL: string) => boolean), // URLアクティブ条件
}
// 幅比率の母数
type WidthDenominator = 3 | 4 | 5 | 6 | 12

// アクティブ時のメニュー
const ActiveMenu = ({menu}: {menu: MENU}) => (
    <li className='bg-white font-bold overflow-hidden overflow-ellipsis whitespace-nowrap'>
        <Link className='flex py-4 px-6' href={isFunction(menu.href) ? menu.href() : menu.href}>
            <div className='w-full flex justify-between items-center'>
                <span>{isFunction(menu.name) ? menu.name() : menu.name}</span>
                <span className='text-gray-400'><GTIcon className='h-4 w-4'/></span>
            </div>
        </Link>
    </li>
)
// 通常時のメニュー
const NonActiveMenu = ({menu}: {menu: MENU}) => (
    <li className='overflow-hidden overflow-ellipsis whitespace-nowrap'>
        <Link className='hover:bg-gray-100 flex py-4 px-6' href={isFunction(menu.href) ? menu.href() : menu.href}>
            {isFunction(menu.name) ? menu.name() : menu.name}
        </Link>
    </li>
)
// メニュー一覧
const MenuLinks = ({menus = []}: {menus: MENU[]}) => (
    <ul className='box-border rounded-sm border border-gray-200 bg-gray-200 text-gray-600 w-full'>
        {
            map(menus, (menu, i) => {
                // アクティブ
                const isActive = menu.active(location.href);
                // メニュー画面描画
                return isActive ? (<ActiveMenu key={i} menu={menu}/>) : (<NonActiveMenu key={i} menu={menu}/>)
            })
        }
    </ul>
)

/**
 * @returns 基本設定画面 レイアウト(左にメニュー 右にコンテンツ形式)
 */
export default function BaseSettingsLayout({ children, className = '', menus = [], widthDenominator = 5, ...props }: PropsWithChildren<AreaHTMLAttributes<HTMLDivElement>> & { menus: MENU[] | ReactNode, widthDenominator?: WidthDenominator }) {
    // 幅の比率 →　左右の幅クラス決定
    const leftWidthClassName = `w-1/${widthDenominator}`, rightWidthClassName = `w-${widthDenominator - 1}/${widthDenominator}`;

    return (
        // wrapper
        <div className={['flex flex-nowrap justify-between', className].join(' ')} {...props}>
            {/* 左メニュー */}
            <div className={[leftWidthClassName].join(' ')}>
                {/* メニュー 描画 */}
                { isArray(menus) ? (<MenuLinks menus={menus}/>) : menus }
            </div>
            {/* 右コンテンツ */}
            <div className={['ml-4', rightWidthClassName].join(' ')}>
                {children}
            </div>
        </div>
    )
}
