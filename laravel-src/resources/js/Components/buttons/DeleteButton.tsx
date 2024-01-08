/* import react */
import { ButtonHTMLAttributes } from 'react';
/* import 部品 */
import { TrashIcon } from '@/Components';

export default function PrimaryButton({ className = '', disabled, children, ...props }: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={
                `inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 ${
                    disabled && 'opacity-25'
                } ` + className
            }
            disabled={disabled}
        >
            <div className='flex items-center justify-between'>
                <TrashIcon className='mr-2 text-white' />
                {children ?? '削除'}
            </div>
        </button>
    );
}
