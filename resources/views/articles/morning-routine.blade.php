<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5分でできる、心地よい朝の過ごし方 | ShopSwift</title>

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
        <span class="text-black font-bold">5分でできる、心地よい朝の過ごし方</span>
    </nav>

    <article class="bg-white border border-gray-200 rounded-3xl overflow-hidden">

        <div class="h-72 md:h-[420px] bg-[#f4eee6] flex items-center justify-center text-8xl md:text-9xl">
            🕯️
        </div>

        <div class="p-6 md:p-12">

            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-6">
                <span class="bg-[#f8f4ef] px-4 py-2 rounded-full font-bold">
                    暮らしのアイデア
                </span>
                <span>2024.05.18</span>
                <span>5 min read</span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold leading-tight mb-8">
                5分でできる、<br class="hidden sm:block">
                心地よい朝の過ごし方
            </h1>

            <p class="text-gray-600 leading-loose text-lg mb-10">
                朝の時間を少し整えるだけで、一日の気分は大きく変わります。
                忙しい日でも無理なく取り入れられる、小さな習慣を紹介します。
            </p>

            <div class="space-y-10 leading-loose text-gray-700">

                <section>
                    <h2 class="text-2xl font-bold mb-4">
                        1. カーテンを開けて、光を入れる
                    </h2>

                    <p>
                        朝起きたら、まずカーテンを開けて自然光を部屋に取り入れます。
                        たったそれだけでも、部屋の空気が切り替わり、気持ちも少し前向きになります。
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4">
                        2. 温かい飲み物をゆっくり飲む
                    </h2>

                    <p>
                        コーヒーや白湯、ハーブティーなど、いつもの飲み物を少しだけ丁寧に用意してみます。
                        忙しい朝でも、ほんの数分の余白があるだけで、気持ちにゆとりが生まれます。
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4">
                        3. 今日使うものを整える
                    </h2>

                    <p>
                        バッグ、デスク、キッチンまわりなど、今日使うものを軽く整えるだけで、
                        一日の始まりがスムーズになります。
                        完璧に片付ける必要はなく、「少し整える」くらいで十分です。
                    </p>
                </section>

                <section class="bg-[#f8f4ef] rounded-3xl p-6 md:p-8">
                    <h2 class="text-2xl font-bold mb-4">
                        ShopSwiftからのひとこと
                    </h2>

                    <p>
                        心地よい暮らしは、大きな変化よりも小さな習慣から生まれます。
                        毎朝の5分を、自分のための時間にしてみてください。
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
                    ShopSwiftでは、毎日の暮らしに自然となじむアイテムを取り扱っています。
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