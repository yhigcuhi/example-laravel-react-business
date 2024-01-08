<?php

namespace App\Notifications;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

/**
 * 従業員 招待 メール通知
 */
class StaffInvitationNotification extends Notification
{
    use Queueable;

    /* フィールド変数 */
    // 宛先名
    private readonly string $name;
    // 招待 事業所 名
    private readonly string $business_name;
    // 招待 URL
    private readonly string $url;

    /**
     * コンストラクタ
     * @param Invitation $invitation 招待管理情報
     */
    public function __construct(Invitation $invitation) {
        // 招待管理情報 → フィールド変数
        $this->name = $invitation->name;
        $this->business_name = $invitation->business->name;
        $this->url = route('invitation.verify', ['invitation_token' => $invitation->invitation_token]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // メール通知のみ 対応
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('招待へのお知らせ')
            ->line(Lang::get(':name 様', ['name' => $this->name]))
            ->line(Lang::get('この度は、:business_name 様より、招待をお預かりしています。', ['business_name' => $this->business_name]))
            ->line(Lang::get('下記ボタンから 共同利用するための手続きを できるようになります'))
            ->action(Lang::get('共同利用を開始する'), $this->url)
            ->line(Lang::get('※ 有効期間は、このメールの送信後24時間です。'))
            ->line(Lang::get('本メールにお心当たりのない方、またはご不明な点やご質問等ございましたら、サポートセンターへお問い合わせください。'))
        ;
    }
}
