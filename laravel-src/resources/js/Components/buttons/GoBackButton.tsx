/* import react */
import { ButtonHTMLAttributes, MouseEventHandler } from 'react';
/* import 部品 */
import { BackIcon } from '@/Components';

/**
 * @return 戻るボタン
 */
export default function GoBackButton({ className = '', backTo, children, ...props }: ButtonHTMLAttributes<HTMLButtonElement> & { backTo?: string}) {
    // 戻るイベントハンドラー
    const handleOnClick: MouseEventHandler = (e) => {
        // バブリング終了
        e.preventDefault()
        // 戻る実行
        backTo ? location.href = backTo : history.back()
    }
    // 画面描画
    return (
        <button
            className={[
                'inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150'
                , className
            ].join(' ')}
            onClick={handleOnClick}
            {...props}
        >
            <div className='flex items-center justify-between'>
                <BackIcon className='mr-2 text-white' />
                {children ?? '戻る'}
            </div>
        </button>
    )
}
