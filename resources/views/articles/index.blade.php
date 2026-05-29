<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] pb-20 md:pb-0 overflow-x-hidden">

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-[1400px] mx-auto h-16 md:h-20 px-4 md:px-8 flex items-center justify-between gap-4">
        <a href="{{ route('products.index') }}" class="text-2xl md:text-3xl font-bold shrink-0">
            ShopSwift
        </a>

        <nav class="hidden lg:flex items-center gap-8 text-sm font-bold">
            <a href="{{ route('products.index') }}" class="hover:text-gray-500">ホーム</a>
            <a href="{{ route('products.all') }}" class="hover:text-gray-500">全商品一覧</a>

            <a href="{{ route('articles.index') }}"
               class="bg-[#070d16] text-white px-5 py-3 rounded-full hover:bg-gray-800">
                Journal
            </a>

            <a href="{{ route('contact.index') }}" class="hover:text-gray-500">お問い合わせ</a>

            @auth
                <a href="{{ route('mypage') }}" class="hover:text-gray-500">マイページ</a>
                <a href="{{ route('orders.index') }}" class="hover:text-gray-500">注文履歴</a>
            @endauth
        </nav>

        <div class="flex items-center gap-3 md:gap-5 shrink-0">
            @auth
                <a href="{{ route('cart.index') }}" class="relative">
                    <i data-lucide="shopping-cart" class="w-7 h-7"></i>
                    <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                    </span>
                </a>

                <a href="{{ route('mypage') }}"
                   class="w-10 h-10 rounded-full bg-[#b8946d] text-white font-bold flex items-center justify-center hover:opacity-90">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="hidden sm:flex bg-[#070d16] text-white px-5 py-3 rounded-full text-sm font-bold">
                    ログイン
                </a>

                <a href="{{ route('login') }}" class="sm:hidden">
                    <i data-lucide="user" class="w-7 h-7"></i>
                </a>
            @endauth
        </div>
    </div>
</header>

<main class="max-w-[1400px] mx-auto px-4 sm:px-6 md:px-8 py-10 md:py-14">

    <section class="bg-[#f8f4ef] rounded-3xl p-8 md:p-12 mb-10">
        <div class="text-gray-500 mb-3">Journal</div>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-5">
            暮らしの読みもの
        </h1>

        <p class="text-gray-600 leading-relaxed max-w-2xl">
            毎日の暮らしを心地よくするアイデアや、ShopSwiftのアイテムの楽しみ方をお届けします。
        </p>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-8 items-start">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-7">

            <article class="bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-500">
                <a href="{{ route('articles.morning-routine') }}" class="block">
                    <div class="h-64 bg-[#f4eee6] flex items-center justify-center text-7xl">
                        🕯️
                    </div>

                    <div class="p-6">
                        <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
                            <span class="bg-[#f8f4ef] px-3 py-1 rounded-full font-bold">暮らしのアイデア</span>
                            <span>2024.05.18</span>
                        </div>

                        <h2 class="text-2xl font-bold mb-3 leading-snug">
                            5分でできる、心地よい朝の過ごし方
                        </h2>

                        <p class="text-gray-600 text-sm leading-relaxed mb-5">
                            朝の時間を少し整えるだけで、一日の気分は大きく変わります。忙しい日でも取り入れやすい小さな習慣を紹介します。
                        </p>

                        <div class="font-bold text-sm">
                            記事を読む →
                        </div>
                    </div>
                </a>
            </article>

            <article class="bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-500">
                <a href="{{ route('articles.aroma-humidifier') }}" class="block">
                    <div class="h-64 bg-[#f4eee6] flex items-center justify-center text-7xl">
                        ☕
                    </div>

                    <div class="p-6">
                        <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
                            <span class="bg-[#f8f4ef] px-3 py-1 rounded-full font-bold">アイテムの使い方</span>
                            <span>2024.05.10</span>
                        </div>

                        <h2 class="text-2xl font-bold mb-3 leading-snug">
                            アロマ加湿器でつくる、リラックス空間
                        </h2>

                        <p class="text-gray-600 text-sm leading-relaxed mb-5">
                            香りと潤いを暮らしに取り入れることで、部屋で過ごす時間がもっと心地よくなります。
                        </p>

                        <div class="font-bold text-sm">
                            記事を読む →
                        </div>
                    </div>
                </a>
            </article>

            <article class="bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-500">
                <a href="{{ route('articles.free-shipping') }}" class="block">
                    <div class="h-64 bg-[#f4eee6] flex items-center justify-center text-7xl">
                        📦
                    </div>

                    <div class="p-6">
                        <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
                            <span class="bg-[#f8f4ef] px-3 py-1 rounded-full font-bold">お知らせ</span>
                            <span>2024.05.01</span>
                        </div>

                        <h2 class="text-2xl font-bold mb-3 leading-snug">
                            送料無料キャンペーンのお知らせ
                        </h2>

                        <p class="text-gray-600 text-sm leading-relaxed mb-5">
                            期間限定で、対象商品の送料無料キャンペーンを実施しています。気になっていた商品を試すきっかけに。
                        </p>

                        <div class="font-bold text-sm">
                            記事を読む →
                        </div>
                    </div>
                </a>
            </article>

            <article class="bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-500">
                <a href="{{ route('products.all') }}" class="block">
                    <div class="h-64 bg-[#eadfd2] flex items-center justify-center text-7xl">
                        🪴
                    </div>

                    <div class="p-6">
                        <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
                            <span class="bg-[#f8f4ef] px-3 py-1 rounded-full font-bold">ShopSwift Select</span>
                            <span>Pick Up</span>
                        </div>

                        <h2 class="text-2xl font-bold mb-3 leading-snug">
                            暮らしになじむアイテムを探す
                        </h2>

                        <p class="text-gray-600 text-sm leading-relaxed mb-5">
                            ShopSwiftで取り扱っている商品一覧から、あなたの暮らしに合うアイテムを探してみましょう。
                        </p>

                        <div class="font-bold text-sm">
                            全商品を見る →
                        </div>
                    </div>
                </a>
            </article>

        </div>

        <aside class="space-y-6">

            <div class="bg-white border border-gray-200 rounded-3xl p-6">
                <h2 class="text-2xl font-bold mb-5">
                    Category
                </h2>

                <div class="space-y-3 text-sm font-bold">
                    <a href="#" class="flex items-center justify-between border border-gray-100 rounded-xl px-4 py-3 hover:bg-gray-50">
                        暮らしのアイデア
                        <span>1</span>
                    </a>

                    <a href="#" class="flex items-center justify-between border border-gray-100 rounded-xl px-4 py-3 hover:bg-gray-50">
                        アイテムの使い方
                        <span>1</span>
                    </a>

                    <a href="#" class="flex items-center justify-between border border-gray-100 rounded-xl px-4 py-3 hover:bg-gray-50">
                        お知らせ
                        <span>1</span>
                    </a>
                </div>
            </div>

            <div class="bg-[#070d16] text-white rounded-3xl p-6">
                <h2 class="text-2xl font-bold mb-4">
                    ShopSwift
                </h2>

                <p class="text-sm text-gray-300 leading-relaxed mb-6">
                    暮らしを、もっと心地よく。シンプルで長く使えるアイテムを揃えています。
                </p>

                <a href="{{ route('products.all') }}"
                   class="inline-flex items-center justify-center bg-white text-[#070d16] px-5 py-3 rounded-xl font-bold">
                    商品を見る
                </a>
            </div>

        </aside>

    </section>

</main>

<footer class="border-t bg-white mt-10">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 md:px-8 py-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-500">
        <div class="font-bold text-[#111827] text-xl">ShopSwift</div>

        <div class="flex flex-wrap gap-4">
            <a href="{{ route('terms') }}" class="hover:text-black">利用規約</a>
            <a href="{{ route('privacy') }}" class="hover:text-black">プライバシーポリシー</a>
            <a href="{{ route('commercial') }}" class="hover:text-black">特定商取引法に基づく表記</a>
            <a href="{{ route('contact.index') }}" class="hover:text-black">お問い合わせ</a>
        </div>
    </div>
</footer>

<nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-gray-200 z-50 grid grid-cols-4 text-xs">
    <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="home" class="w-5 h-5"></i>
        ホーム
    </a>

    <a href="{{ route('products.all') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="layout-grid" class="w-5 h-5"></i>
        全商品
    </a>

    <a href="{{ route('articles.index') }}" class="flex flex-col items-center justify-center gap-1 font-bold">
        <i data-lucide="book-open" class="w-5 h-5"></i>
        記事
    </a>

    <a href="{{ auth()->check() ? route('mypage') : route('login') }}"
       class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="user" class="w-5 h-5"></i>
        {{ auth()->check() ? 'マイページ' : 'ログイン' }}
    </a>
</nav>

<script>
    lucide.createIcons();
</script>

</body>
</html>