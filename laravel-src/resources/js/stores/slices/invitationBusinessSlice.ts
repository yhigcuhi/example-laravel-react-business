/* import redux */
import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
/* import api */
import { fetchAll as fetchAllAPI } from '@/apis/invitationBusiness';
/* import type */
import { InvitationBusiness } from '@/types';
import { RootState } from '../index';

/* type定義 */
// Stateの型
type State = {
    invitationBusinesses: InvitationBusiness[] // 招待されている 事業所 一覧
    // TODO:通信系 State共通化 するか？
    isLoading: boolean // 読み込み中
    error?: object // エラー TODO:形は？ axiosから作るなら共通化したい {message, code}必須とか
}

/* 内部参照可能関数定義 */
// ログインユーザーの 招待されている 事業所一覧 取得 イベント(dispatchさせる)
export const fetchAll = createAsyncThunk<InvitationBusiness[]>(
    'invitationBusinesses/fetchAll',
    // 非同期処理内容
    async () => {
        // 通信実行
        const response = await fetchAllAPI();
        // 結果返却
        return response.data?.data;
    }
);

// 初期値 定義
const initialState: State = {
    invitationBusinesses: [],
    isLoading: false,
    error: undefined,
};
/**
 * 招待されている 事業所 スライス
 */
export const invitationBusinessSlice = createSlice({
    // TODO:フィールドアクセス名?
    name: 'invitationBusiness',
    // 初期値
    initialState,
    // reducer
    reducers: {
        // TODO: 承認・否認
    },
    // 非同期 関数 reducer
    extraReducers: (builder) => {
        // TODO:下記の処理共通化したい
        builder
            // 一覧取得 通信中
            .addCase(fetchAll.pending, (state) => {
                state.isLoading = true;
                state.error = undefined;
            })
            // 一覧取得 通信完了(成功)
            .addCase(fetchAll.fulfilled, (state, action) => {
                state.isLoading = false;
                state.invitationBusinesses = action.payload; // fetchAllが実行され、返り値がstateに入る
                state.error = undefined;
            })
            // 一覧取得 通信完了(失敗)
            .addCase(fetchAll.rejected, (state, action) => {
                state.isLoading = false;
                // TODO:一旦エラーのメッセージだけに
                state.error = action.error;
            });
    },
})

// export getter
export const selectInvitationBusiness = (state: RootState) => state.invitationBusiness
// export reducer
export default invitationBusinessSlice.reducer
