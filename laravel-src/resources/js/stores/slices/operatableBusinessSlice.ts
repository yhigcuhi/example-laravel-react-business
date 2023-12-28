/* import redux */
import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
/* import api */
import { fetchAll as fetchAllAPI } from '@/apis/operatableBusiness';
/* import type */
import { OperatableBusiness } from '@/types';
import { RootState } from '../index';

/* type定義 */
// Stateの型
type State = {
    operatableBusinesses: OperatableBusiness[] // 操作可能 事業所 一覧
    // TODO:通信系 State共通化 するか？
    isLoading: boolean // 読み込み中
    error?: object // エラー TODO:形は？ axiosから作るなら共通化したい {message, code}必須とか
}

/* 内部参照可能関数定義 */
// ログインユーザーの 操作可能 事業所一覧 取得 イベント(dispatchさせる)
export const fetchAll = createAsyncThunk<OperatableBusiness[]>(
    'operatableBusiness/fetchAll',
    // 非同期処理内容
    async () => {
        console.log('あれ？2')
        // 通信実行
        const response = await fetchAllAPI();
        // 結果返却
        return response.data?.data;
    }
);


// 初期値 定義
const initialState: State = {
    operatableBusinesses: [],
    isLoading: false,
    error: undefined,
};
/**
 * 操作可能 事業所 スライス
 */
export const operatableBusinessSlice = createSlice({
    // TODO:フィールドアクセス名?
    name: 'operatableBusiness',
    // 初期値
    initialState,
    // reducer
    reducers: {},
    // 非同期 関数 reducer
    extraReducers: (builder) => {
        builder
            // 一覧取得 通信中
            .addCase(fetchAll.pending, (state) => {
                state.isLoading = true;
                state.error = undefined;
            })
            // 一覧取得 通信完了(成功)
            .addCase(fetchAll.fulfilled, (state, action) => {
                state.isLoading = false;
                state.operatableBusinesses = action.payload; // fetchAllが実行され、返り値がstateに入る
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

// export const { increment, decrement, incrementByAmount } = counterSlice.actions
// export getter
export const selectOperatableBusiness = (state: RootState) => state.operatableBusiness.value
// export reducer
export default operatableBusinessSlice.reducer
