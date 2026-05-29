<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プライバシーポリシー | ShopSwift</title>

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
        <div class="text-gray-500 mb-3">Privacy Policy</div>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-5">
            プライバシーポリシー
        </h1>

        <p class="text-gray-600 leading-relaxed">
            本ページはデモサイト用のサンプルです。実際に運用する場合は、個人情報の取り扱い内容・利用目的・管理体制に合わせて確認・修正してください。
        </p>
    </section>

    <section class="bg-white border border-gray-200 rounded-3xl p-6 md:p-10 space-y-8 leading-loose">

        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 text-sm text-yellow-800">
            <p class="font-bold mb-2">デモ用ページについて</p>
            <p>
                本サイトは制作実績・デモ表示を目的としたサンプルサイトです。
                実際の商品販売・個人情報取得・サービス提供を目的としたものではありません。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">1. 個人情報の取得について</h2>
            <p class="text-gray-700">
                ShopSwiftデモサイトでは、お問い合わせフォーム、会員登録、注文手続きなどの画面を想定し、
                氏名、メールアドレス、住所、電話番号などの情報項目を表示しています。
                ただし、本ページの内容はデモ用のサンプル文面です。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">2. 個人情報の利用目的</h2>
            <p class="text-gray-700 mb-3">
                実運用時には、取得した個人情報を以下の目的で利用することが想定されます。
            </p>

            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>商品の発送および注文管理のため</li>
                <li>お問い合わせへの返信のため</li>
                <li>会員情報の管理のため</li>
                <li>サービス改善および不正利用防止のため</li>
                <li>必要な連絡や重要なお知らせを行うため</li>
            </ul>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">3. 個人情報の第三者提供について</h2>
            <p class="text-gray-700">
                取得した個人情報は、法令に基づく場合を除き、本人の同意なく第三者へ提供しないものとします。
                実際に外部サービスを利用する場合は、利用する決済サービス・配送サービス等に合わせて内容を確認してください。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">4. 外部サービスの利用について</h2>
            <p class="text-gray-700">
                本デモサイトでは、決済機能やメール送信機能など、外部サービスとの連携を想定しています。
                実運用時には、利用する外部サービスの規約・プライバシーポリシーも確認してください。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">5. 安全管理について</h2>
            <p class="text-gray-700">
                個人情報を取り扱う場合は、不正アクセス、紛失、改ざん、漏えい等を防止するため、
                適切な安全管理措置を講じる必要があります。
                本ページはデモ用であり、実際の管理体制を示すものではありません。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">6. Cookie等の利用について</h2>
            <p class="text-gray-700">
                実運用時には、アクセス解析やログイン状態の保持などの目的でCookieを利用する場合があります。
                利用する解析ツールや広告サービスに応じて、記載内容を調整してください。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">7. お問い合わせ窓口</h2>
            <p class="text-gray-700">
                個人情報の取り扱いに関するお問い合わせは、下記のお問い合わせフォームよりご連絡ください。
            </p>

            <div class="mt-4">
                <a href="{{ route('contact.index') }}"
                   class="inline-flex items-center justify-center bg-[#070d16] text-white px-6 py-3 rounded-xl font-bold">
                    お問い合わせ
                </a>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">8. プライバシーポリシーの変更</h2>
            <p class="text-gray-700">
                本ページの内容は、デモサイトの構成に応じて予告なく変更される場合があります。
                実運用時には、変更履歴や改定日を明記することをおすすめします。
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">9. 免責事項</h2>
            <p class="text-gray-700">
                本ページはデモ用の雛形であり、法的な正確性や完全性を保証するものではありません。
                実際に運用する場合は、事業内容に合わせて内容を確認し、必要に応じて専門家へご相談ください。
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

        <a href="{{ route('terms') }}"
           class="inline-flex items-center justify-center border border-gray-300 px-6 py-4 rounded-xl font-bold hover:bg-white">
            利用規約を見る
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