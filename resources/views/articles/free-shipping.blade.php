<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送料無料キャンペーンのお知らせ | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] pb-20 md:pb-0 overflow-x-hidden">

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-[1200px] mx-auto h-16 md:h-20 px-4 md:px-8 flex items-center justify-between gap-4">
        <a href="{{ route('products.index') }}" class="text-2xl md:text-3xl font-bold">
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
            @else
                <a href="{{ route('login') }}" class="hover:text-gray-500">ログイン</a>
            @endauth
        </nav>

        <a href="{{ auth()->check() ? route('mypage') : route('login') }}" class="lg:hidden">
            <i data-lucide="user" class="w-7 h-7"></i>
        </a>
    </div>
</header>

<main class="max-w-[1000px] mx-auto px-4 sm:px-6 md:px-8 py-10 md:py-14">

    <nav class="mb-6 text-sm text-gray-500 flex flex-wrap items-center gap-2">
        <a href="{{ route('products.index') }}" class="hover:text-black">ホーム</a>
        <span>›</span>
        <a href="{{ route('articles.index') }}" class="hover:text-black">Journal</a>
        <span>›</span>
        <span class="text-black font-bold">送料無料キャンペーンのお知らせ</span>
    </nav>

    <article class="bg-white border border-gray-200 rounded-3xl overflow-hidden">

        <div class="h-72 md:h-[420px] bg-[#f4eee6] flex items-center justify-center text-8xl md:text-9xl">
            📦
        </div>

        <div class="p-6 md:p-12">

            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-6">
                <span class="bg-[#f8f4ef] px-4 py-2 rounded-full font-bold">
                    お知らせ
                </span>
                <span>2024.05.01</span>
                <span>3 min read</span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold leading-tight mb-8">
                送料無料キャンペーンの<br class="hidden sm:block">
                お知らせ
            </h1>

            <p class="text-gray-600 leading-loose text-lg mb-10">
                ShopSwiftでは、より気軽に商品をお試しいただけるよう、
                期間限定の送料無料キャンペーンを実施しています。
            </p>

            <div class="space-y-10 leading-loose text-gray-700">

                <section>
                    <h2 class="text-2xl font-bold mb-4">
                        キャンペーン内容
                    </h2>

                    <p>
                        期間中、対象商品を含むご注文について、通常発生する送料を無料とするキャンペーンを実施しています。
                        気になっていたアイテムを試すきっかけとして、ぜひご利用ください。
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4">
                        対象商品について
                    </h2>

                    <p>
                        インテリア、キッチン、リラックスアイテムなど、暮らしに寄り添う商品を中心に対象商品を用意しています。
                        対象商品は商品一覧ページよりご確認いただけます。
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4">
                        ご利用時の注意
                    </h2>

                    <ul class="list-disc list-inside space-y-2">
                        <li>本ページはデモサイト用のお知らせ記事です。</li>
                        <li>実際のキャンペーン内容ではありません。</li>
                        <li>実運用時は、対象期間・対象商品・送料条件を正確に記載してください。</li>
                    </ul>
                </section>

                <section class="bg-[#f8f4ef] rounded-3xl p-6 md:p-8">
                    <h2 class="text-2xl font-bold mb-4">
                        ShopSwiftからのひとこと
                    </h2>

                    <p>
                        日々の暮らしに自然となじむアイテムを、少しでも手に取りやすく。
                        そんな想いを込めたキャンペーンです。
                    </p>
                </section>

            </div>

            <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('articles.index') }}"
                   class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white px-6 py-4 rounded-xl font-bold hover:bg-gray-800">
                    ← 記事一覧へ戻る
                </a>

                <a href="{{ route('products.all') }}"
                   class="inline-flex items-center justify-center gap-2 border border-gray-300 px-6 py-4 rounded-xl font-bold hover:bg-gray-50">
                    商品を見る
                    <span>→</span>
                </a>
            </div>

        </div>
    </article>

    <section class="mt-10 bg-[#070d16] text-white rounded-3xl p-8 md:p-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-3">
                    対象商品を見てみる
                </h2>

                <p class="text-gray-300 leading-relaxed">
                    ShopSwiftの全商品一覧から、暮らしに合うアイテムを探してみてください。
                </p>
            </div>

            <a href="{{ route('products.all') }}"
               class="inline-flex items-center justify-center bg-white text-[#070d16] px-6 py-4 rounded-xl font-bold">
                全商品を見る
            </a>
        </div>
    </section>

</main>

<footer class="border-t bg-white mt-10">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 md:px-8 py-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-500">
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