<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>特定商取引法に基づく表記 | ShopSwift</title>

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
                <a href="{{ route('mypage') }}"
                   class="bg-[#070d16] text-white px-5 py-3 rounded-full hover:bg-gray-800">
                    マイページ
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="bg-[#070d16] text-white px-5 py-3 rounded-full hover:bg-gray-800">
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
        <div class="text-gray-500 mb-3">Specified Commercial Transaction Act</div>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-5 leading-tight">
            特定商取引法に基づく表記
        </h1>

        <p class="text-gray-600 leading-relaxed">
            本ページはデモサイト用のサンプルです。実際に運用する場合は、販売者情報・販売条件・返品条件などを事業内容に合わせて確認・修正してください。
        </p>
    </section>

    <section class="bg-white border border-gray-200 rounded-3xl p-6 md:p-10 space-y-8 leading-loose">

        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 text-sm text-yellow-800">
            <p class="font-bold mb-2">デモ用ページについて</p>
            <p>
                本サイトは制作実績・デモ表示を目的としたサンプルサイトです。
                実際の商品販売・サービス提供を目的としたものではありません。
                表記内容はダミー情報です。
            </p>
        </div>

        <div class="overflow-hidden border border-gray-200 rounded-2xl">
            <dl class="divide-y divide-gray-200">

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        販売事業者
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        ShopSwift デモストア
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        運営責任者
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        山田 太郎（サンプル）
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        所在地
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        東京都渋谷区〇〇 1-2-3（サンプル住所）
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        電話番号
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        03-0000-0000（サンプル）
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        メールアドレス
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        sample@example.com
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        販売価格
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        各商品ページに表示された価格をご確認ください。表示価格は税込価格のサンプルです。
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        商品代金以外の必要料金
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        送料、振込手数料、決済手数料などが発生する場合があります。
                        本デモサイトではサンプル表示です。
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        支払い方法
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        クレジットカード決済を想定しています。実運用時は利用する決済サービスに合わせて記載してください。
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        支払い時期
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        ご注文時に決済が確定する想定です。実際の支払い時期は決済方法により異なります。
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        商品の引渡し時期
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        ご注文確認後、通常2〜5営業日以内に発送する想定です。
                        デモサイトのため、実際の発送は行っていません。
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        返品・交換について
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        商品到着後7日以内にお問い合わせください。
                        ただし、使用済み商品やお客様都合による返品は対応できない場合があります。
                        実運用時は販売商品に合わせて条件を調整してください。
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        返品送料
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        不良品・誤配送の場合は販売者負担、お客様都合の場合はお客様負担を想定しています。
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        申込みの有効期限
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        ご注文後、一定期間内に決済が確認できない場合はキャンセルとなる場合があります。
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[240px_1fr]">
                    <dt class="bg-gray-50 px-5 py-4 font-bold text-gray-700">
                        販売数量
                    </dt>
                    <dd class="px-5 py-4 text-gray-700">
                        各商品ページに表示される在庫数をご確認ください。
                    </dd>
                </div>

            </dl>
        </div>

        <div class="bg-gray-50 rounded-2xl p-5 text-sm text-gray-600 leading-relaxed">
            <p class="font-bold text-[#111827] mb-2">実運用時の注意</p>
            <p>
                本ページはデモ用の雛形であり、法的な正確性や完全性を保証するものではありません。
                実際にECサイトとして運用する場合は、販売者情報・配送条件・返品条件・決済条件などを正確な内容に差し替え、
                必要に応じて専門家へ確認してください。
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