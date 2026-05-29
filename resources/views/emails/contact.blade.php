<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ</title>
</head>
<body style="font-family: sans-serif; color: #111827; line-height: 1.8;">

    <h2>ShopSwiftにお問い合わせが届きました</h2>

    <p>以下の内容でお問い合わせが送信されました。</p>

    <hr>

    <p>
        <strong>お名前：</strong><br>
        {{ $contactData['name'] }}
    </p>

    <p>
        <strong>メールアドレス：</strong><br>
        {{ $contactData['email'] }}
    </p>

    <p>
        <strong>件名：</strong><br>
        {{ $contactData['subject'] }}
    </p>

    <p>
        <strong>お問い合わせ内容：</strong><br>
        {!! nl2br(e($contactData['message'])) !!}
    </p>

    <hr>

    <p style="font-size: 12px; color: #6b7280;">
        このメールはShopSwiftのお問い合わせフォームから自動送信されています。
    </p>

</body>
</html>