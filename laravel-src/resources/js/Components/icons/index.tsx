/* アイコン部品集約 */
/* import react */
import { SVGAttributes } from 'react';

// チェックアイコン
export const CheckIcon = (props: SVGAttributes<SVGElement>) => (
    <svg {...props} xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-green-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round">
        <polyline points="20 6 9 17 4 12" />
    </svg>
);
