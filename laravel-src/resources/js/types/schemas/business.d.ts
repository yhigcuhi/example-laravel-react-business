/* 事業所定義系 */
/* import 共通 */
import { ID } from '@/types/schemas';

// 事業所
export type Business = {
    id: ID
    name: string
}
// 操作可能 事業所
export type OperatableBusiness = {
    id: ID
    business: Business // 対象 事業所情報
    is_operating: boolean
}
