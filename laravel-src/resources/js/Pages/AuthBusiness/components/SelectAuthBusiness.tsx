/* import react */
import { useEffect } from 'react';
/* import inertiajs */
import { useForm } from '@inertiajs/react';
/* import lodash */
import { join, map } from 'lodash';
/* import hooks */
import { useAppDispatch, useAppSelector } from '@/hooks/useMyStore';
/* import store */
import { fetchAll } from '@/stores/slices/operatableBusinessSlice';
/* import 部品 */
import { Card, Table, TH, TD, CheckIcon } from '@/Components';
import { ID } from '@/types';

// 事業所 一覧ヘッダー
const TableHeader = ({className = ''}) => (
    <tr className={className}>
        <TH className='w-2/12'>ログイン中</TH>
        <TH className='w-6/12'>会社名</TH>
        <TH className='w-4/12 text-center'>メニュー</TH>
    </tr>
)
/**
 * 操作する 事業所 選択(事業所 認証) 部品
 */
export default function SelectAuthBusiness() {
    // dispatcher 具現化
    const dispatch = useAppDispatch();
    // 操作可能 事業所一覧
    const {operatableBusinesses, isLoading} = useAppSelector((state) => state.operatableBusiness);
    // 操作中へのフォーム
    const { patch } = useForm();

    /* イベントハンドラー */
    // 操作中へ 選択(事業所 認証) クリックハンドラー
    const onSelectForAuth = (id: ID) => {
        // 操作中へ更新
        patch(route('operatableBusiness.operating', {id}));
    }
    // 画面表示時
    useEffect(() => {
        // 最新取得 実行
        dispatch(fetchAll())
    }, [dispatch]);

    // 通信中
    if (isLoading) return (<div>is loading ... TODO:共通化したい</div>)
    // 画面描画
    return (
        // 操作可能 事業所 一覧
        <Card>
            {/* 一覧表形式 */}
            <Table className="my-6 border border-gray-200" header={<TableHeader />} headerClassName='bg-gray-200'>
                {/* 一覧表: ボディ */}
                {
                    map(operatableBusinesses, ({id, business: {name}, is_operating}, i) => {
                        // 表示行のクラス決定
                        const className = join([
                            'border-b hover:bg-gray-100', // 共通
                            is_operating ? 'cursor-not-allowed' : 'cursor-pointer' // ポインタ 操作中の事業所: クリック不可 / それ以外:クリック可能
                        ], ' ');
                        // 画面描画
                        return (
                            // 各行 表示
                            <tr key={i} className={className} onClick={() => is_operating ? {} : onSelectForAuth(id)} >
                                <TH className='text-center'>{is_operating ? (<CheckIcon className='text-center'/>) : ''}</TH>
                                <TH>{name}</TH>
                                <TD className='text-center'>削除ボタン?</TD>
                            </tr>
                        )
                    })
                }
            </Table>
        </Card>
    );
}
