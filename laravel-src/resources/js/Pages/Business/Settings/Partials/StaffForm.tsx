/* import react */
import { FormHTMLAttributes, FormEventHandler } from 'react';
import { Transition } from '@headlessui/react';
/* import inertia */
import { useForm } from '@inertiajs/react';
/* import 部品 */
import { InputLabel, TextInput, InputError, GoBackButton, PrimaryButton } from '@/Components';
/* import lodash */
import { size } from 'lodash'
/* import type */
import { Staff } from '@/types';

// フォーム
type InputForm = {
    last_name: string, // 姓
    first_name: string, // 名
    last_kana: string, // セイ
    first_kana: string, // メイ
    email: string, // 紐づくアカウントのメアド
    user_id: number | null // 該当ユーザーID (重複登録エラーを表示するよう)
}
// 画面表示引数
type Props = FormHTMLAttributes<HTMLFormElement> & { staff: Staff, onSubmit?: (input: InputForm) => void}
/**
 * @returns 従業員 登録/更新 フォーム
 */
export default function StaffForm({ staff, className = '', onSubmit }: Props) {
    // フォーム通信
    const { data, setData, patch, post, errors, processing, recentlySuccessful } = useForm<InputForm>({
        last_name: staff.last_name ?? '', // 姓
        first_name: staff.first_name ?? '', // 名
        last_kana: staff.last_kana ?? '', // セイ
        first_kana: staff.first_kana ?? '', // メイ
        email: staff.email ?? '', // 紐づくアカウントのメアド
        user_id: staff.user_id,
    });
    // 保存処理実行
    const save = () => {
        // スタッフID指定あり →　管理画面 更新
        if (staff.id) patch(route('business.settings.staff.update', {id: staff.id}));
        // それ以外 → 管理画面 登録
        else post(route('business.settings.staff.store'));
    }

    // サブミットハンドラー
    const handleOnSubmit: FormEventHandler = (e) => {
        // その他処理終了
        e.preventDefault();
        // onSubmitハンドリングあり → そちら実行
        if (onSubmit) onSubmit(data);
        // なし →　独自の登録・更新 実行
        else save();
    };
    return (
        // 編集フォーム
        <form onSubmit={handleOnSubmit} className={['mt-6 space-y-6', className].join(' ')}>
            {/* アカウント(メアド): メアド変更 管理者できない(一旦) */}
            <div className={staff.user_id ? 'hidden' : ''}>
                <InputLabel htmlFor="email" value="(任意) メールアドレス" className='mb-2 text-gray-500' />
                {/* TODO:メアドから ユーザー検索して 氏名とかをコピペするような機能 今後時間あれば */}
                <TextInput
                    id="email"
                    type='email'
                    className="my-2 block w-full"
                    value={data.email || ''}
                    onChange={(e) => setData('email', e.target.value)}
                    isFocused
                    autoComplete="test@example.com"
                />
                {/* フォームエラー */}
                <InputError className="mt-2" message={errors.user_id} />
            </div>
            {/* 氏名 */}
            <div>
                <span className="my-2 w-full grid grid-cols-2 gap-4">
                    <span className="flex flex-col">
                        <InputLabel htmlFor="last_name" value="姓" className='mb-2' />
                        <TextInput
                            id="last_name"
                            className="block"
                            value={data.last_name}
                            onChange={(e) => setData('last_name', e.target.value)}
                            required
                            maxLength={20}
                            pattern="[^A-Za-z0-9１-９]*"
                            autoComplete="田中"
                        />
                    </span>
                    <span className="flex flex-col">
                        <InputLabel htmlFor="first_name" value="名" className='mb-2' />
                        <TextInput
                            id="first_name"
                            className="block"
                            value={data.first_name}
                            onChange={(e) => setData('first_name', e.target.value)}
                            required
                            maxLength={20}
                            pattern="[^A-Za-z0-9１-９]*"
                            autoComplete="太郎"
                        />
                    </span>
                </span>
                {/* フォームエラー */}
                <InputError className="mt-2" message={errors.last_name ?? errors.first_name} />
            </div>
            {/* フリガナ */}
            <div>
                <span className="my-2 w-full grid grid-cols-2 gap-4">
                    <span className="flex flex-col">
                        <InputLabel htmlFor="last_kana" value="セイ" className='mb-2' />
                        <TextInput
                            id="last_kana"
                            className="block"
                            value={data.last_kana}
                            onChange={(e) => setData('last_kana', e.target.value)}
                            required
                            maxLength={20}
                            pattern="^[ァ-ンヴー]+$"
                            autoComplete="タナカ"
                        />
                    </span>
                    <span className="flex flex-col">
                        <InputLabel htmlFor="first_kana" value="メイ" className='mb-2' />
                        <TextInput
                            id="first_kana"
                            className="block"
                            value={data.first_kana}
                            onChange={(e) => setData('first_kana', e.target.value)}
                            required
                            maxLength={20}
                            pattern="^[ァ-ンヴー]+$"
                            autoComplete="タロウ"
                        />
                    </span>
                </span>
                {/* フォームエラー */}
                <InputError className="mt-2" message={errors.last_kana ?? errors.first_kana} />
            </div>
            {/* フォームフッター */}
            <div className="flex items-center justify-end gap-4">
                {/* 保存完了アニメーション */}
                <Transition
                    show={recentlySuccessful}
                    enter="transition ease-in-out"
                    enterFrom="opacity-0"
                    leave="transition ease-in-out"
                    leaveTo="opacity-0"
                >
                    <p className="text-sm text-gray-600">登録しました</p>
                </Transition>
                {/* キャンセルボタン */}
                <GoBackButton>キャンセル</GoBackButton>
                {/* 保存ボタン */}
                <PrimaryButton disabled={(size(errors) > 0 || processing)} />
            </div>
        </form>
    )
}
