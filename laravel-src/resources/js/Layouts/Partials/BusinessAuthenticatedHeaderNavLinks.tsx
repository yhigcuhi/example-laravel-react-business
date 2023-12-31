/* import react */
import { AreaHTMLAttributes } from 'react';
/* import 部品 */
import { NavLink } from '@/Components';
import { map, isFunction } from 'lodash'
/* import types */
import { User } from '@/types';

//　内部参照定数:ナビゲーションメニュー 一覧
interface NAV_LINK {
    name: string | ((user: User) => string), // 画面表示名
    href: string | ((user: User) => string), // URL
    active: ((user: User) => boolean), // URLアクティブ条件
}
// 事業所サービスとしてのナビゲーションメニュー 一覧
const NAV_LINKS_FOR_BUSINESS: NAV_LINK[] = [
    {
        name: (user) => user.operating_business?.business.name || '',
        href: route('business.show'),
        active: () => route().current('business.show'),
    },
    {
        name: '事業所 設定',
        href: route('business.settings'),
        active: () => route().current('business.settings*'),
    },
]
// 事業所の 勤怠サービスとしてのナビゲーションメニュー 一覧
const NAV_LINKS_FOR_BUSINESS_ATTENDANCE: NAV_LINK[] = [
    {
        name: '勤怠(attendanceサービス) TODO:',
        href: route('dashboard'),
        active: () => route().current('dashboard'),
    },
    {
        name: '勤怠 管理 TODO:',
        href: route('dashboard'),
        active: () => route().current('dashboard'),
    },
]

/**
 * @returns (操作中 事業所決まった後)事業所 認証後のヘッダーリンク
 */
export default function BusinessAuthenticatedHeaderNavLinks({ user, className = '' }: AreaHTMLAttributes<HTMLDivElement> & { user: User}) {
    return (
        // ナビゲーションメニュー ラッパー
        <div className={['space-x-8', className].join(' ')}>
            {/* TODO:サービス・権限別にナビゲーションメニュー表示非表示を作る (余力できたら) */}
            {/* 事業所サービス メニュー一覧 */}
            {
                map(NAV_LINKS_FOR_BUSINESS, ({name, href, active}, i) => (
                    <NavLink key={i} href={isFunction(href) ? href(user) : href} active={active(user)}>
                        {isFunction(name) ? name(user) : name}
                    </NavLink>
                ))
            }
            {/* 事業所 勤怠サービス メニュー一覧 */}
            {
                map(NAV_LINKS_FOR_BUSINESS_ATTENDANCE, ({name, href, active}, i) => (
                    <NavLink key={i + NAV_LINKS_FOR_BUSINESS.length} href={isFunction(href) ? href(user) : href} active={isFunction(active) ? active(user) : active}>
                        {isFunction(name) ? name(user) : name}
                    </NavLink>
                ))
            }
        </div>
    )
}
