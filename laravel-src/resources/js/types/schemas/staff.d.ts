/* 従業員 定義系 */
/* import 共通 */
import { ID } from '@/types/schemas';

// 従業員
export type Staff = {
    id: ID
    business_id: ID
    user_id: ID | null
    first_name: string
    last_name: string
    first_kana: string
    last_kana: string
    // 更新不可
    name: string
    kana: string
    email: string | null
​}

