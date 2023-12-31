/* import react */
import { AreaHTMLAttributes, FormEventHandler } from 'react';
import { Transition } from '@headlessui/react';
/* import inertia */
import { useForm } from '@inertiajs/react';
/* import 部品 */
import { InputLabel, TextInput, InputError, PrimaryButton } from '@/Components';
/* import lodash */
import { size } from 'lodash'
/* import type */
import { Business } from '@/types';

/**
 * @returns 事業所 プロフィール 更新フォーム TODO:新規登録作成時に Update → をなくすか考えるs
 */
export default function UpdateBusinessProfileForm({ business, className = '' }: AreaHTMLAttributes<HTMLFormElement> & {business: Business}) {
    // フォーム通信
    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        name: business.name,
    });


    // サブミットハンドラー
    const onSubmit: FormEventHandler = (e) => {
        // その他処理終了
        e.preventDefault();
        // TODO:登録画面作成時に検討 呼び出し元にハンドリングさせるか、完了後の画面
        patch(route('business.settings.profile.update'));
    };
    return (
        // 編集フォーム
        <form onSubmit={onSubmit} className={['mt-6 space-y-6', className].join(' ')}>
            {/* 画面表示名 */}
            <div>
                <InputLabel htmlFor="name" value="会社名" className='mb-2' />
                <TextInput
                    id="name"
                    className="my-2 block w-full"
                    value={data.name}
                    onChange={(e) => setData('name', e.target.value)}
                    required
                    isFocused
                    autoComplete="〇〇株式会社"
                />
                {/* フォームエラー */}
                <InputError className="mt-2" message={errors.name} />
            </div>
            {/* フォームフッター */}
            <div className="flex items-center gap-4">
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
                {/* 保存ボタン */}
                <PrimaryButton disabled={(size(errors) > 0 || processing)} />
            </div>
        </form>
    )
}
