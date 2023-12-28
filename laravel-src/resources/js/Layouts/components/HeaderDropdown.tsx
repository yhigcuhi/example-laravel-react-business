/* import react */
import { PropsWithChildren } from 'react';
/* import 部品 */
import Dropdown from '@/Components/Dropdown';
/* import types */
import { User } from '@/types';

/**
 * @returns ヘッダードロップダウンリスト
 */
export default function HeaderDropdown({ user }: PropsWithChildren<{ user: User }>) {
    return (
        <Dropdown>
            {/* ドロップダウン 開閉トリガー */}
            <Dropdown.Trigger>
                {/* 開閉ボタン */}
                <span className="inline-flex rounded-md">
                    {/* ユーザー名 + 開閉ボタン */}
                    <button
                        type="button"
                        className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    >
                        {/* ユーザー名 */}
                        {user.name}
                        {/* 開閉ボタン TODO:上下回転アニメーション */}
                        <svg
                            className="ms-2 -me-0.5 h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fillRule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clipRule="evenodd"
                            />
                        </svg>
                    </button>
                </span>
            </Dropdown.Trigger>
            {/* ドロップダウン コンテンツ */}
            <Dropdown.Content>
                {/* ドロップダウン メニュー */}
                <Dropdown.Link href={route('profile.edit')}>プロフィール</Dropdown.Link>
                {/* TODO:事業所 複数登録に対応し始めたら */}
                {/* <Dropdown.Link href={route('operatableBusiness.index')}>事業所 一覧</Dropdown.Link> */}
                <Dropdown.Link href={route('logout')} method="post" as="button">ログアウト</Dropdown.Link>
            </Dropdown.Content>
        </Dropdown>
    );
}
