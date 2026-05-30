<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>決済キャンセル | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="w-full max-w-[1200px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

    <header class="sticky top-0 z-40 bg-white h-16 sm:h-20 px-4 sm:px-8 flex items-center justify-between border-b border-gray-100">

        <a href="{{ route('products.index') }}" class="text-xl sm:text-2xl font-bold">
            ShopSwift
        </a>

        <nav class="hidden lg:flex items-center gap-10 text-sm font-medium">
            <a href="{{ route('products.index') }}" class="hover:text-gray-500">
                ホーム
            </a>

            <a href="{{ route('products.all') }}" class="hover:text-gray-500">
                商品一覧
            </a>

            <a href="{{ route('orders.index') }}" class="hover:text-gray-500">
                注文履歴
            </a>

            <a href="{{ route('mypage') }}" class="hover:text-gray-500">
                マイページ
            </a>
        </nav>

        <div class="flex items-center gap-5 sm:gap-6">

            <a href="{{ route('cart.index') }}" class="relative">
                <i data-lucide="shopping-cart" class="w-7 h-7 sm:w-6 sm:h-6"></i>

                <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                </span>
            </a>

            <a href="{{ route('mypage') }}">
                <i data-lucide="user" class="w-7 h-7 sm:w-6 sm:h-6"></i>
            </a>

        </div>

    </header>

    <main class="px-4 sm:px-8 py-10 sm:py-16">

        <div class="max-w-2xl mx-auto">

            <div class="bg-white border border-gray-200 rounded-3xl p-6 sm:p-10 text-center">

                <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-8 rounded-3xl bg-yellow-100 flex items-center justify-center">
                    <i data-lucide="circle-alert" class="w-10 h-10 sm:w-12 sm:h-12 text-yellow-700"></i>
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    決済をキャンセルしました
                </h1>

                <p class="text-gray-500 leading-relaxed mb-8">
                    お支払いは完了していません。<br class="hidden sm:block">
                    カート内の商品はそのまま残っています。
                </p>

                <div class="bg-gray-50 rounded-2xl p-5 sm:p-6 mb-8 text-left">

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-gray-500"></i>
                        </div>

                        <div>
                            <div class="font-bold mb-1">
                                もう一度購入手続きできます
                            </div>

                            <p class="text-sm text-gray-500 leading-relaxed">
                                カートへ戻ると、配送先情報を確認して再度お支払いへ進めます。
                            </p>
                        </div>
                    </div>

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    <a href="{{ route('cart.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white px-6 py-4 rounded-2xl font-bold hover:bg-gray-800 transition">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                        カートへ戻る
                    </a>

                    <a href="{{ route('products.all') }}"
                       class="inline-flex items-center justify-center gap-2 border border-gray-200 px-6 py-4 rounded-2xl font-bold hover:bg-gray-50 transition">
                        <i data-lucide="package" class="w-5 h-5"></i>
                        商品一覧を見る
                    </a>

                </div>

            </div>

        </div>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>