/* import react */
import { useState, PropsWithChildren, ReactNode } from 'react';
/* import inertiajs */
import { Link } from '@inertiajs/react';
/* import 部品 */
import { ApplicationLogo, ResponsiveNavLink } from '@/Components';
import { HeaderDropdown as Dropdown, BusinessAuthenticatedHeaderNavLinks as NavLinks } from './Partials';
/* import types */
import { User, Business } from '@/types';

// 共通ヘッダー
const Header = ({title}: {title?: string}) => (
    <header className="bg-white shadow">
        <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">{title}</h2>
        </div>
    </header>
)

/**
 * @returns (操作中 事業所決まった後)事業所 認証後の画面 レイアウト
 */
export default function BusinessAuthenticated({ user, title, children }: PropsWithChildren<{ user: User, title?: string }>) {
    // ハンバーガーメニュー開閉 監視 TODO:共通系は1つのファイルにしたい
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);
    // 画面描画
    return (
        <div className="min-h-screen bg-gray-100">
            <nav className="bg-white border-b border-gray-100">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex">
                            <div className="shrink-0 flex items-center">
                                {/* ロゴ →　事業所 認証後のTOPへ */}
                                <Link href={route('business.show')}>
                                    <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>
                            {/* ヘッダー ナビゲーションメニュー */}
                            <NavLinks user={user} className="hidden sm:-my-px sm:ms-10 sm:flex" />
                        </div>
                        {/* PC版 右メニュー */}
                        <div className="hidden sm:flex sm:items-center sm:ms-6">
                            <div className="ms-3 relative">
                                {/* ドロップダウン */}
                                <Dropdown user={user} />
                            </div>
                        </div>
                        {/* スマホ版 右メニュー TODO:今後 */}
                        <div className="-me-2 flex items-center sm:hidden">
                            <button
                                onClick={() => setShowingNavigationDropdown((previousState) => !previousState)}
                                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        className={showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                {/* TODO:スマホ用 余力できたら */}
                <div className={(showingNavigationDropdown ? 'block' : 'hidden') + ' sm:hidden'}>
                    <div className="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink href={route('dashboard')} active={route().current('dashboard')}>
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <div className="pt-4 pb-1 border-t border-gray-200">
                        <div className="px-4">
                            <div className="font-medium text-base text-gray-800">
                                {user.name}
                            </div>
                            <div className="font-medium text-sm text-gray-500">{user.email}</div>
                        </div>

                        <div className="mt-3 space-y-1">
                            <ResponsiveNavLink href={route('profile.edit')}>Profile</ResponsiveNavLink>
                            <ResponsiveNavLink method="post" href={route('logout')} as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>
            {/* ヘッダー */}
            <Header title={title ?? user.operating_business?.business.name} />
            {/* メインコンテンツ */}
            <main>{children}</main>
        </div>
    );
}
