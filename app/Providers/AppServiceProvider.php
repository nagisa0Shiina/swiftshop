<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    ResetPassword::toMailUsing(function (object $notifiable, string $token) {
        $url = route('password.reset', [
            'token' => $token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject('【ShopSwift】パスワード再設定のご案内')
            ->greeting('ShopSwiftをご利用いただきありがとうございます。')
            ->line('パスワード再設定のリクエストを受け付けました。')
            ->line('下のボタンから、新しいパスワードを設定してください。')
            ->action('パスワードを再設定する', $url)
            ->line('このリンクの有効期限は一定時間です。')
            ->line('このメールに心当たりがない場合は、何も操作せず破棄してください。')
            ->salutation('ShopSwift');
    });

    VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        return (new MailMessage)
            ->subject('【ShopSwift】メールアドレス認証のお願い')
            ->greeting('ShopSwiftへようこそ。')
            ->line('アカウント登録ありがとうございます。')
            ->line('下のボタンをクリックして、メールアドレスの認証を完了してください。')
            ->action('メールアドレスを認証する', $url)
            ->line('メール認証が完了すると、カート・注文・マイページ機能をご利用いただけます。')
            ->line('このメールに心当たりがない場合は、何も操作せず破棄してください。')
            ->salutation('ShopSwift');
    });
    }
}