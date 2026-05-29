<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アロマ加湿器でつくる、リラックス空間 | ShopSwift</title>

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
        <span class="text-black font-bold">アロマ加湿器でつくる、リラックス空間</span>
    </nav>

    <article class="bg-white border border-gray-200 rounded-3xl overflow-hidden">

        <div class="h-72 md:h-[420px] bg-[#f4eee6] flex items-center justify-center text-8xl md:text-9xl">
            ☕
        </div>

        <div class="p-6 md:p-12">

            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-6">
                <span class="bg-[#f8f4ef] px-4 py-2 rounded-full font-bold">
                    アイテムの使い方
                </span>
                <span>2024.05.10</span>
                <span>4 min read</span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold leading-tight mb-8">
                アロマ加湿器でつくる、<br class="hidden sm:block">
                リラックス空間
            </h1>

            <p class="text-gray-600 leading-loose text-lg mb-10">
                香りと潤いを暮らしに取り入れることで、部屋で過ごす時間はもっと心地よくなります。
                一日の終わりにほっと落ち着ける空間づくりのヒントを紹介します。
            </p>

            <div class="space-y-10 leading-loose text-gray-700">

                <section>
                    <h2 class="text-2xl font-bold mb-4">
                        1. 香りは強すぎないものを選ぶ
                    </h2>

                    <p>
                        リラックス空間をつくるときは、香りが強すぎないものを選ぶのがおすすめです。
                        ラベンダー、柑橘系、ウッド系など、自然に部屋になじむ香りを少量から試してみましょう。
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4">
                        2. 置く場所で雰囲気が変わる
                    </h2>

                    <p>
                        アロマ加湿器は、ベッドサイド、デスク横、リビングの棚など、
                        置く場所によって印象が変わります。
                        直接風が当たる場所や、精密機器の近くは避け、安定した場所に置くと安心です。
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4">
                        3. 夜の照明と合わせる
                    </h2>

                    <p>
                        部屋の照明を少し落として、柔らかい明かりと一緒に使うと、
                        より落ち着いた雰囲気になります。
                        眠る前の時間や、読書の時間にもぴったりです。
                    </p>
                </section>

                <section class="bg-[#f8f4ef] rounded-3xl p-6 md:p-8">
                    <h2 class="text-2xl font-bold mb-4">
                        ShopSwiftからのひとこと
                    </h2>

                    <p>
                        香りや湿度を少し整えるだけで、いつもの部屋が自分らしい場所になります。
                        忙しい日ほど、心をゆるめる時間を大切にしてみてください。
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
                    暮らしに合うアイテムを探す
                </h2>

                <p class="text-gray-300 leading-relaxed">
                    ShopSwiftでは、リラックスタイムに合うシンプルなアイテムも取り扱っています。
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