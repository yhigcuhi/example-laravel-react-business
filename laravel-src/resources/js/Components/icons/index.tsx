/* アイコン部品集約 */
/* import react */
import { SVGAttributes } from 'react';

// Tailwind CSS W,Hサイズs
const toTailwindSize = (size: number): string => `h-${size} w-${size}`;
// チェックアイコン
export const CheckIcon = ({className = '', size = 6, ...props}: SVGAttributes<SVGElement> & {size?: number}) => (
    <svg {...props} xmlns="http://www.w3.org/2000/svg" className={['text-green-500', toTailwindSize(size), className].join(' ')} viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round">
        <polyline points="20 6 9 17 4 12" />
    </svg>
);

// > アイコン
export const GTIcon =  ({className = '', size = 4, ...props}: SVGAttributes<SVGElement> & {size?: number}) => (
    <svg {...props} xmlns="http://www.w3.org/2000/svg" className={[' text-gray-500', toTailwindSize(size), className].join(' ')} width="24" height="24" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor" fill="none" strokeLinecap="round" strokeLinejoin="round">
            <path stroke="none" d="M0 0h24v24H0z"/>
            <polyline points="9 6 15 12 9 18" />
    </svg>
);
