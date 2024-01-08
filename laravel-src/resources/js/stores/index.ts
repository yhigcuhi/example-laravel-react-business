/* import redux */
import { configureStore } from '@reduxjs/toolkit';
/* import slice */
// TODO:名前は auth businessにしようかな... なんかここの意味的に operatableBusinessへアクセスするはちがそう
import operatableBusinessReducer from './slices/operatableBusinessSlice'
import invitationBusinessReducer from './slices/invitationBusinessSlice'

// ルートストア定義
export const store = configureStore({
    reducer: {
        // 操作可能 事業所 管理
        operatableBusiness: operatableBusinessReducer,
        invitationBusiness: invitationBusinessReducer,
    },
})

// type定義
// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>
// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch
