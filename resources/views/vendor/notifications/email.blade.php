@props(['url'])
@php
    $brandColor = '#070d16';
    $accentColor = '#b8946d';
@endphp

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ShopSwift</title>
</head>

<body style="margin:0; padding:0; background:#f8f4ef; font-family:-apple-system,BlinkMacSystemFont,'Helvetica Neue','Yu Gothic',YuGothic,sans-serif; color:#111827;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8f4ef; padding:40px 16px;">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:640px; background:#ffffff; border-radius:28px; overflow:hidden; border:1px solid #eadfd2;">

                <tr>
                    <td style="background:#f4eee6; padding:36px 32px; text-align:center;">
                        <div style="font-size:30px; font-weight:800; color:#111827; margin-bottom:10px;">
                            ShopSwift
                        </div>

                        <div style="font-size:14px; color:#6b7280;">
                            暮らしを、もっと心地よく。
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:40px 32px;">

                        @if (! empty($greeting))
                            <h1 style="margin:0 0 24px; font-size:24px; line-height:1.5; color:#111827;">
                                {{ $greeting }}
                            </h1>
                        @else
                            <h1 style="margin:0 0 24px; font-size:24px; line-height:1.5; color:#111827;">
                                ShopSwiftからのお知らせ
                            </h1>
                        @endif

                        @foreach ($introLines as $line)
                            <p style="margin:0 0 16px; font-size:15px; line-height:1.9; color:#374151;">
                                {{ $line }}
                            </p>
                        @endforeach

                        @isset($actionText)
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin:32px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $actionUrl }}"
                                           style="display:inline-block; background:{{ $brandColor }}; color:#ffffff; text-decoration:none; padding:16px 28px; border-radius:14px; font-weight:700; font-size:15px;">
                                            {{ $actionText }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        @endisset

                        @foreach ($outroLines as $line)
                            <p style="margin:0 0 16px; font-size:15px; line-height:1.9; color:#374151;">
                                {{ $line }}
                            </p>
                        @endforeach

                        @if (! empty($salutation))
                            <p style="margin:32px 0 0; font-size:15px; line-height:1.8; color:#374151;">
                                {{ $salutation }}
                            </p>
                        @else
                            <p style="margin:32px 0 0; font-size:15px; line-height:1.8; color:#374151;">
                                ShopSwift
                            </p>
                        @endif

                    </td>
                </tr>

                @isset($actionText)
                    <tr>
                        <td style="padding:0 32px 36px;">
                            <div style="background:#f8f4ef; border:1px solid #eadfd2; border-radius:18px; padding:20px;">
                                <p style="margin:0 0 10px; font-size:13px; color:#6b7280; line-height:1.7;">
                                    ボタンが押せない場合は、以下のURLをコピーしてブラウザに貼り付けてください。
                                </p>

                                <p style="margin:0; font-size:12px; line-height:1.7; word-break:break-all; color:#374151;">
                                    {{ $actionUrl }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endisset

                <tr>
                    <td style="background:#070d16; padding:28px 32px; text-align:center;">
                        <p style="margin:0 0 8px; color:#ffffff; font-size:14px; font-weight:700;">
                            ShopSwift
                        </p>

                        <p style="margin:0; color:#d1d5db; font-size:12px; line-height:1.7;">
                            このメールはShopSwiftから自動送信されています。<br>
                            心当たりがない場合は、このメールを破棄してください。
                        </p>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>