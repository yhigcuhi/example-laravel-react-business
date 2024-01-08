/* import react */
import { useEffect } from 'react';
/* import inertiajs */
import { useForm } from '@inertiajs/react';
/* import lodash */
import { join, map } from 'lodash';
/* import hooks */
import { useAppDispatch, useAppSelector } from '@/hooks/useMyStore';
/* import store */
import { fetchAll } from '@/stores/slices/invitationBusinessSlice';
/* import 部品 */
import { Card, Table, TH, TD, DeleteButton, PrimaryButton, CheckIcon } from '@/Components';
import { ID } from '@/types';

// 事業所 一覧ヘッダー
const TableHeader = ({className = ''}) => (
    <tr className={className}>
        <TH className='w-2/12'></TH>
        <TH className='w-6/12'>招待いただいている 事業所名（TODO:役割とか）</TH>
        <TH className='w-4/12 text-center'>メニュー</TH>
    </tr>
)
/**
 * 招待された 事業所 選択(事業所 招待 承認) 部品 TODO:招待承認のロジックミス 修正したらやる
 */
export default function SelectAuthBusiness() {
    // dispatcher 具現化
    const dispatch = useAppDispatch();
    // 招待 事業所一覧
    const {invitationBusinesses, isLoading} = useAppSelector((state) => state.invitationBusiness);
    // 承認へのフォーム
    const { patch } = useForm();

    /* イベントハンドラー */
    // 招待 承認 クリックハンドラー
    const onClickVerifeid = (id: ID) => {
        // 招待の承認
        patch(route('invitation.verifeid', {id}));
    }
    // 画面表示時
    useEffect(() => {
        // 最新取得 実行
        dispatch(fetchAll())
    }, [dispatch]);

    // 通信中
    if (isLoading) return (<div>is loading ... TODO:共通化したい</div>)
    // 空
    if (!invitationBusinesses.length) return null;
    // 画面描画
    return (
        // 操作可能 事業所 一覧
        <Card title="招待されている 事業所" subTitle="※ お心当たりのない場合は、否認を押してください">
            {/* 一覧表形式 */}
            <Table className="my-6 border border-gray-200" header={<TableHeader />} headerClassName='bg-gray-200'>
                {/* 一覧表: ボディ */}
                {
                    map(invitationBusinesses, ({ id, business: {name}}, i) => {
                        // 表示行のクラス決定
                        const className = join([
                            'border-b hover:bg-gray-100', // 共通
                        ], ' ');
                        // 画面描画
                        return (
                            // 各行 表示
                            <tr key={i} className={className} >
                                <TH className='text-center'>{i + 1}</TH>
                                <TH>{name}</TH>
                                <TD className='text-center'>
                                    {/* 操作メニュー */}
                                    <div className="flex items-center justify-end mt-4">
                                        <DeleteButton className="ms-4">否認(TODO:今後)</DeleteButton>
                                        <PrimaryButton className="ms-4" onClick={() => onClickVerifeid(id)}>
                                            <div className='flex items-center justify-between'>
                                                <CheckIcon size={4} className='mr-2 text-white' />
                                                承認
                                            </div>
                                        </PrimaryButton>
                                    </div>
                                </TD>
                            </tr>
                        )
                    })
                }
            </Table>
        </Card>
    );
}
