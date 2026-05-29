<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>決済完了</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white rounded-2xl shadow p-10 text-center max-w-lg w-full">

    <div class="text-6xl mb-6">
        🎉
    </div>

    <h1 class="text-4xl font-bold mb-4">
        決済完了
    </h1>

    <p class="text-gray-600 mb-8">
        ご購入ありがとうございました。
    </p>

    <a href="{{ route('products.index') }}"
       class="inline-block bg-black text-white px-8 py-4 rounded-xl">

        商品一覧へ戻る

    </a>

</div>

</body>
</html>