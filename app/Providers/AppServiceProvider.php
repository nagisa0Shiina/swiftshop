<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
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
        /*
             |--------------------------------------------------------------------------
             | 本番URLを強制
             |--------------------------------------------------------------------------
             | 認証メール・パスワード再設定メール内のURLが localhost になるのを防ぐ
             */
     
     
             URL::forceRootUrl(config('app.url'));
             if(str_starts_with(config('app.url'), 'https://')){
                 URL::forceScheme('https');
             }
     
     
                  /*
             |--------------------------------------------------------------------------
             | メール認証URLを生成
             |--------------------------------------------------------------------------
             */
     
     
             VerifyEmail::createUrlUsing(function(object $notifiable){
                 return URL::temporarySignedRoute(
                     'verification.verify',
                     now()->addMinutes(Config::get('auth.verification.expire', 60)),
                     [
                         'id' => $notifiable->getKey(),
                         'hash' => sha1($notifiable->getEmailForverification()),
                     ]
                 );
     
     
             });

                
              /*
        |--------------------------------------------------------------------------
        | パスワード再設定URLを生成
        |--------------------------------------------------------------------------
        */
        
        ResetPassword::createUrlUsing(function(object $notifiable, string $token){

        return route('password.reset',[
            'token' => $token,
            'email' => $notifiable->getEmailForpasswordReset(),
        ]);


        });
        


        
        
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