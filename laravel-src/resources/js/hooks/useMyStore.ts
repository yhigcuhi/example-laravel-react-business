/* redux共通アクセス hooks */
/* import redux */
import { useDispatch, useSelector } from 'react-redux'
import type { TypedUseSelectorHook } from 'react-redux'
/* import store */
import type { RootState, AppDispatch } from '@/stores'

/* export 共通storeアクセス 関数 */
// 共通 redux store dispatcher
export const useAppDispatch: () => AppDispatch = useDispatch
// 共通 redux store getter
export const useAppSelector: TypedUseSelectorHook<RootState> = useSelector
