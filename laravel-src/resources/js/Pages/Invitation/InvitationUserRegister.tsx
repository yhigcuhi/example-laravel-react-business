/* import inertia */
import { Head } from '@inertiajs/react';
/* import layouts */
import { GuestLayout } from '@/Layouts';
/* import 部品 */
import { InvitationUserRegisterForm } from './Partials';

// 画面表示引数
type PageProps = {
    invitation_token: string // 招待コード →　どの招待からの会員登録なのか用
};
/**
 * @returns 会員登録 by 招待 画面
 */
export default function InvitationUserRegister({ invitation_token }: PageProps) {
    // 画面表示 = 見た目は 通常会員登録と同じ
    return (
        <GuestLayout>
            <Head title="会員登録" />
            {/* 会員登録フォーム (アクション先 = 会員登録 POST by 招待) */}
            <InvitationUserRegisterForm action={route('invitation.user.register.store', { invitation_token })} />
        </GuestLayout>
    );
}
