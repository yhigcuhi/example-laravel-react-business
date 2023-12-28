/* ユーザー定義系 */
/* import 共通 */
import { ID, OperatableBusiness } from '@/types/schemas';

// TODO:システムとしての権限定義など
// ユーザー定義 by breezeベース
export interface User {
    id: ID;
    name: string;
    email: string;
    email_verified_at: string;
    operating_business?: OperatableBusiness// 操作中の事業所(NULL:複数選択でない or 事業所なし)
    // role TODO:権限など実装時
}
