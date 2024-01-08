/* import react */
import { FormHTMLAttributes, useEffect, FormEventHandler } from 'react';
/* import inertia */
import { Link, useForm } from '@inertiajs/react';
/* import 部品 */
import { InputError, InputLabel, TextInput, PrimaryButton } from '@/Components';
/* import lodash */
import { size } from 'lodash'

/* import type */
// フォーム内容
type State = {
    name: string,
    email: string,
    password: string,
    password_confirmation: string,
}
// 画面表示引数
type Props = FormHTMLAttributes<HTMLFormElement> & { action: string, onSubmit?: (data: State) => void }

/**
 * @param param0 フォーム部品表示引数 (action 先のURL指定必須)
 * @returns 会員登録フォーム 部品
 */
export default function UserRegisterForm({ action, onSubmit = () => {}, ...props }: Props) {
    // 会員登録フォーム 制御
    const { data, setData, post, processing, errors, reset } = useForm<State>({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });
    // 画面表示時
    useEffect(() => {
        return () => {
            // パスワード系 入力 クリア強制
            reset('password', 'password_confirmation');
        };
    }, []);
    // onSubmit
    const submit: FormEventHandler = (e) => {
        // バブリング禁止
        e.preventDefault();
        // 呼び出し元の ハンドリング実施
        onSubmit(data);
        // 会員登録通信 (通信先 指定値：必須)
        post(action);
    };

    //　画面描画
    return (
        // 会員登録フォーム
        <form onSubmit={submit} {...props}>
            {/* 画面表示名 */}
            <div>
                <InputLabel htmlFor="name" value="アカウント名" />
                <TextInput
                    id="name"
                    name="name"
                    value={data.name}
                    className="mt-1 block w-full"
                    autoComplete="name"
                    isFocused={true}
                    onChange={(e) => setData('name', e.target.value)}
                    required
                />
                {/* エラー */}
                <InputError message={errors.name} className="mt-2" />
            </div>
            {/* メールアドレス */}
            <div className="mt-4">
                <InputLabel htmlFor="email" value="メールアドレス" />
                <TextInput
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    className="mt-1 block w-full"
                    autoComplete="username"
                    onChange={(e) => setData('email', e.target.value)}
                    required
                />
                <InputError message={errors.email} className="mt-2" />
            </div>
            {/* パスワード */}
            <div className="mt-4">
                <InputLabel htmlFor="password" value="パスワード" />
                <TextInput
                    id="password"
                    type="password"
                    name="password"
                    value={data.password}
                    className="mt-1 block w-full"
                    autoComplete="new-password"
                    onChange={(e) => setData('password', e.target.value)}
                    required
                />
                <InputError message={errors.password} className="mt-2" />
            </div>
            {/* パスワード 確認 */}
            <div className="mt-4">
                <InputLabel htmlFor="password_confirmation" value="パスワード確認" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    value={data.password_confirmation}
                    className="mt-1 block w-full"
                    autoComplete="new-password"
                    onChange={(e) => setData('password_confirmation', e.target.value)}
                    required
                />
                <InputError message={errors.password_confirmation} className="mt-2" />
            </div>
            {/* フォームフッター */}
            <div className="flex items-center justify-end mt-4">
                {/* もしアカウントを持っている場合 → ログインへ リンク */}
                <Link
                    href={route('login')}
                    className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    アカウントを持っている場合はこちらから。
                </Link>
                {/* 登録ボタン */}
                <PrimaryButton className="ms-4" disabled={(size(errors) > 0 || processing)}>登録する</PrimaryButton>
            </div>
        </form>
    );
}
