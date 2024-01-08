/* import inertia */
import { Head } from '@inertiajs/react';
/* import layouts */
import { GuestLayout } from '@/Layouts';
/* import 部品 */
import { UserRegisterForm } from './Partials';

/**
 * @returns 会員登録 画面
 */
export default function Register() {
    // 画面表示
    return (
        <GuestLayout>
            <Head title="会員登録" />
            {/* 会員登録フォーム */}
            <UserRegisterForm action={route('register')} />
        </GuestLayout>
    );
}
