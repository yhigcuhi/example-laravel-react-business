/* import react */
import { PropsWithChildren } from 'react';
/* import inertia */
import { Link } from '@inertiajs/react';
/* import 部品 */
import { EditIcon } from '@/Components';

/**
 * @return 編集ボタン
 */
export default function EditButton({ className = '', href, children, ...props }: PropsWithChildren & {className?: string, href: string}) {
    return (
        <Link
            className={[
                'inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
                , className
            ].join(' ')}
            href={href}
            {...props}
        >
            <div className='flex items-center justify-between'>
                <EditIcon className='mr-2 text-white' />
                {children ?? '編集'}
            </div>
        </Link>
    )
}
