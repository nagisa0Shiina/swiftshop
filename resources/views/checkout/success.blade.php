<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>決済完了 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="w-full max-w-[1300px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

<x-site-header />


{{-- Mobile Drawer --}}
<div id="siteMobileMenu"
     class="fixed inset-0 z-[999] pointer-events-none">

    <div id="siteMobileOverlay"
         class="absolute inset-0 bg-black/0 transition-all duration-300"></div>

    <aside id="siteMobilePanel"
           class="absolute right-0 top-0 h-full w-[86%] max-w-[360px] bg-white shadow-2xl translate-x-full transition-transform duration-500 ease-[cubic-bezier(0.22,1,0.36,1)] flex flex-col">

        <div class="px-6 py-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">ShopSwift</div>
                <div class="mt-1 text-xs tracking-[0.25em] text-gray-400">MENU</div>
            </div>

            <button type="button"
                    id="siteMenuClose"
                    class="w-11 h-11 rounded-full bg-gray-100 flex items-center justify-center">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <nav class="flex-1 px-6 py-7 space-y-2 overflow-y-auto">

            <a href="{{ route('products.index') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4  bg-gray-50 text-[#111827] font-bold">
                <span>ホーム</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>

            <a href="{{ route('products.all') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                <span>全商品を見る</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>

            <a href="{{ route('products.index') }}#products"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                <span>人気商品</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>

            <a href="{{ route('articles.index') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                <span>Journal</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>

            <a href="{{ route('contact.index') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                <span>お問い合わせ</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>

            @auth
                <div class="pt-5 mt-5 border-t border-gray-100 space-y-2">
                    <a href="{{ route('mypage') }}"
                       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                        <span>マイページ</span>
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </a>

                    <a href="{{ route('cart.index') }}"
                       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                        <span>カート</span>
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    </a>

                    <a href="{{ route('orders.index') }}"
                       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                        <span>注文履歴</span>
                        <i data-lucide="receipt-text" class="w-5 h-5"></i>
                    </a>
                </div>
            @endauth

        </nav>

        <div class="px-6 py-6 border-t border-gray-100">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-2xl bg-red-50 text-red-500 px-5 py-4 font-bold flex items-center justify-center gap-3">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        ログアウト
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="w-full rounded-2xl bg-[#070d16] text-white px-5 py-4 font-bold flex items-center justify-center gap-3">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    ログイン
                </a>
            @endauth
        </div>

    </aside>
</div>


    <main class="px-4 sm:px-8 py-10 sm:py-16">

        <div class="max-w-2xl mx-auto">

            <div class="bg-white border border-gray-200 rounded-3xl p-6 sm:p-10 text-center">

                <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-8 rounded-3xl bg-green-100 flex items-center justify-center">
                    <i data-lucide="check" class="w-10 h-10 sm:w-12 sm:h-12 text-green-700"></i>
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    決済が完了しました
                </h1>

                <p class="text-gray-500 leading-relaxed mb-8">
                    ご購入ありがとうございます。<br class="hidden sm:block">
                    注文内容は注文履歴から確認できます。
                </p>

                @isset($order)
                    <div class="bg-gray-50 rounded-2xl p-5 sm:p-6 mb-8 text-left">

                        <h2 class="text-xl font-bold mb-5">
                            注文情報
                        </h2>

                        <div class="space-y-4 text-sm sm:text-base">

                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500">
                                    注文番号
                                </span>

                                <span class="font-bold">
                                    #{{ $order->id }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500">
                                    合計金額
                                </span>

                                <span class="font-bold">
                                    ¥{{ number_format($order->total_amount) }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500">
                                    決済状況
                                </span>

                                <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                    決済完了
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500">
                                    発送状況
                                </span>

                                <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold">
                                    発送準備中
                                </span>
                            </div>

                        </div>

                    </div>
                @endisset

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    <a href="{{ route('orders.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white px-6 py-4 rounded-2xl font-bold hover:bg-gray-800 transition">
                        <i data-lucide="receipt" class="w-5 h-5"></i>
                        注文履歴を見る
                    </a>

                    <a href="{{ route('products.all') }}"
                       class="inline-flex items-center justify-center gap-2 border border-gray-200 px-6 py-4 rounded-2xl font-bold hover:bg-gray-50 transition">
                        <i data-lucide="package" class="w-5 h-5"></i>
                        商品一覧へ戻る
                    </a>

                </div>

            </div>

        </div>

    </main>

</div>

<script>
    lucide.createIcons();
       const siteMenuOpen = document.getElementById('siteMenuOpen');
    const siteMenuClose = document.getElementById('siteMenuClose');
    const siteMobileMenu = document.getElementById('siteMobileMenu');
    const siteMobileOverlay = document.getElementById('siteMobileOverlay');
    const siteMobilePanel = document.getElementById('siteMobilePanel');

    function openSiteMenu() {
        if (!siteMobileMenu || !siteMobileOverlay || !siteMobilePanel) return;

        siteMobileMenu.classList.remove('pointer-events-none');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            siteMobileOverlay.classList.remove('bg-black/0');
            siteMobileOverlay.classList.add('bg-black/45');

            siteMobilePanel.classList.remove('translate-x-full');
            siteMobilePanel.classList.add('translate-x-0');
        });
    }

    function closeSiteMenu() {
        if (!siteMobileMenu || !siteMobileOverlay || !siteMobilePanel) return;

        siteMobileOverlay.classList.remove('bg-black/45');
        siteMobileOverlay.classList.add('bg-black/0');

        siteMobilePanel.classList.remove('translate-x-0');
        siteMobilePanel.classList.add('translate-x-full');

        setTimeout(() => {
            siteMobileMenu.classList.add('pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }, 500);
    }

    if (siteMenuOpen) {
        siteMenuOpen.addEventListener('click', openSiteMenu);
    }

    if (siteMenuClose) {
        siteMenuClose.addEventListener('click', closeSiteMenu);
    }

    if (siteMobileOverlay) {
        siteMobileOverlay.addEventListener('click', closeSiteMenu);
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeSiteMenu();
        }
    });


        /*
    |--------------------------------------------------------------------------
    | User dropdown
    |--------------------------------------------------------------------------
    */
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');

    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', (event) => {
            event.stopPropagation();
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }



</script>

</body>
</html>