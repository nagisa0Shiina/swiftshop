<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>利用規約 | ShopSwift</title>

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
            <a href="{{ route('contact.index') }}" class="hover:text-gray-500">お問い合わせ</a>

            @auth
                <a href="{{ route('mypage') }}" class="bg-[#070d16] text-white px-5 py-3 rounded-full hover:bg-gray-800">
                    マイページ
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-[#070d16] text-white px-5 py-3 rounded-full hover:bg-gray-800">
                    ログイン
                </a>
            @endauth
        </nav>

        <a href="{{ auth()->check() ? route('mypage') : route('login') }}" class="lg:hidden">
            <i data-lucide="user" class="w-7 h-7"></i>
        </a>
    </div>
</header>

<main class="max-w-[1000px] mx-auto px-4 sm:px-6 md:px-8 py-10 md:py-14">

    <section class="bg-[#f8f4ef] rounded-3xl p-8 md:p-12 mb-8">
        <div class="text-gray-500 mb-3">Terms of Service</div>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-5">
            利用規約
        </h1>

        <p class="text-gray-600 leading-relaxed">
            本ページはデモサイト用のサンプルです。実際に運用する場合は、事業内容・販売内容・法令に合わせて内容を確認・修正してください。
        </p>
    </section>

    <section class="bg-white border border-gray-200 rounded-3xl p-6 md:p-10 space-y-8 leading-loose">

        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 text-sm text-yellow-800">
            <p class="font-bold mb-2">デモ用ページについて</p>
            <p>
                本サイトは制作実績・デモ表示を目的としたサンプルサイトです。
                実際の商品販売・サービス提供を目的としたものではありません。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">第1条 本規約について</h2>
            <p class="text-gray-700">
                本利用規約は、ShopSwiftデモサイトの閲覧および利用に関する条件を示すサンプル文面です。
                実運用時には、提供するサービス内容に合わせて正式な規約を作成してください。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">第2条 サービスの利用</h2>
            <p class="text-gray-700">
                ユーザーは、本サイトを法令および公序良俗に反しない範囲で利用するものとします。
                本ページの内容はデモ用であり、実際の契約条件を示すものではありません。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">第3条 禁止事項</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>不正アクセスまたはそれに類する行為</li>
                <li>他のユーザーまたは第三者に不利益を与える行為</li>
                <li>本サイトの運営を妨げる行為</li>
                <li>その他、管理者が不適切と判断する行為</li>
            </ul>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">第4条 商品・サービスについて</h2>
            <p class="text-gray-700">
                本デモサイトに掲載されている商品情報、価格、画像、説明文はサンプルです。
                実際の商品販売を行う場合は、正確な情報へ差し替えてください。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">第5条 免責事項</h2>
            <p class="text-gray-700">
                本ページはデモ用の雛形であり、法的な正確性や完全性を保証するものではありません。
                実運用の際は、必要に応じて専門家へ確認してください。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">第6条 規約の変更</h2>
            <p class="text-gray-700">
                本ページの内容は、デモサイトの構成に応じて予告なく変更される場合があります。
            </p>
        </div>

        <div class="pt-6 border-t border-gray-100 text-sm text-gray-500">
            制定日：2026年1月1日<br>
            ShopSwift デモサイト
        </div>

    </section>

    <div class="mt-8 flex flex-col sm:flex-row gap-4">
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center justify-center bg-[#070d16] text-white px-6 py-4 rounded-xl font-bold">
            トップへ戻る
        </a>

        <a href="{{ route('contact.index') }}"
           class="inline-flex items-center justify-center border border-gray-300 px-6 py-4 rounded-xl font-bold hover:bg-white">
            お問い合わせ
        </a>
    </div>

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

    <a href="{{ route('contact.index') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="mail" class="w-5 h-5"></i>
        問合せ
    </a>

    <a href="{{ auth()->check() ? route('mypage') : route('login') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="user" class="w-5 h-5"></i>
        {{ auth()->check() ? 'マイページ' : 'ログイン' }}
    </a>
</nav>

<script>
    lucide.createIcons();
</script>

</body>
</html>