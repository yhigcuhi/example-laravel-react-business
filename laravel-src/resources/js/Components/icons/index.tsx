/* アイコン部品集約 */
/* import react */
import { SVGAttributes as BaseSVGAttributes } from 'react';

// type定義
type SVGAttributes = BaseSVGAttributes<SVGElement> & {size?: number}

// Tailwind CSS W,Hサイズs
const toTailwindSize = (size: number): string => `h-${size} w-${size}`;
// チェックアイコン
export const CheckIcon = ({className = '', size = 6, ...props}: SVGAttributes) => (
    <svg {...props} xmlns="http://www.w3.org/2000/svg" className={['text-green-500', toTailwindSize(size), className].join(' ')} viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round">
        <polyline points="20 6 9 17 4 12" />
    </svg>
);
// > アイコン
export const GTIcon = ({className = '', size = 4, ...props}: SVGAttributes) => (
    <svg {...props} xmlns="http://www.w3.org/2000/svg" className={['text-gray-500', toTailwindSize(size), className].join(' ')} width="24" height="24" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor" fill="none" strokeLinecap="round" strokeLinejoin="round">
        <path stroke="none" d="M0 0h24v24H0z"/>
        <polyline points="9 6 15 12 9 18" />
    </svg>
);
// + アイコン
export const PlusIcon = ({className = '', size = 4, ...props}: SVGAttributes) => (
    <svg {...props} xmlns="http://www.w3.org/2000/svg" className={['text-gray-500', toTailwindSize(size), className].join(' ')} fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4"/>
    </svg>
);
// ←(戻る) アイコン
export const BackIcon = ({className = '', size = 4, ...props}: SVGAttributes) => (
    <svg  {...props} xmlns="http://www.w3.org/2000/svg" className={['text-gray-500', toTailwindSize(size), className].join(' ')} width="24" height="24" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor" fill="none" strokeLinecap="round" strokeLinejoin="round">
        <path stroke="none" d="M0 0h24v24H0z"/>
        <path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" />
    </svg>
);
// 編集 アイコン
export const EditIcon = ({className = '', size = 4, ...props}: SVGAttributes) => (
    <svg  {...props} xmlns="http://www.w3.org/2000/svg" className={['text-gray-500', toTailwindSize(size), className].join(' ')} viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor" fill="none" strokeLinecap="round" strokeLinejoin="round">
        <path stroke="none" d="M0 0h24v24H0z"/>
        <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
        <line x1="16" y1="5" x2="19" y2="8" />
    </svg>
);
// ゴミ箱 アイコン
export const TrashIcon = ({className = '', size = 4, ...props}: SVGAttributes) => (
    <svg {...props} xmlns="http://www.w3.org/2000/svg" className={['text-gray-500', toTailwindSize(size), className].join(' ')} fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
    </svg>
);
