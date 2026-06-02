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
    <div class="max-w-[1500px] mx-auto h-16 md:h-20 px-4 md:px-8 flex items-center justify-between gap-4">

        <a href="{{ route('products.index') }}" class="text-2xl md:text-3xl font-bold shrink-0">
            ShopSwift
        </a>

        {{-- PC Nav --}}
        <nav class="hidden lg:flex items-center gap-8 text-sm font-bold">
            <a href="{{ route('products.index') }}"
               class="hover:text-gray-500">
                ホーム
            </a>

            <a href="{{ route('products.all') }}"
               class="hover:text-gray-500 ">
                全商品を見る
            </a>

            <a href="{{ route('products.index') }}#products"
               class="hover:text-gray-500">
                人気商品
            </a>

            <a href="{{ route('articles.index') }}"
               class="hover:text-gray-500">
                Journal
            </a>

            <a href="{{ route('contact.index') }}"
               class="hover:text-gray-500">
                お問い合わせ
            </a>

            @auth
                <a href="{{ route('mypage') }}"
                   class="hover:text-gray-500">
                    マイページ
                </a>

                <a href="{{ route('orders.index') }}"
                   class="hover:text-gray-500">
                    注文履歴
                </a>
            @endauth
        </nav>

        <div class="flex items-center gap-3 md:gap-5 shrink-0">

            {{-- PC Search --}}
            <form method="GET"
                  action="{{ route('products.index') }}"
                  class="hidden md:flex items-center gap-2 border border-gray-200 rounded-full px-4 py-2.5 bg-white">
                <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
                <input
                    name="keyword"
                    value="{{ $keyword ?? '' }}"
                    placeholder="人気商品を検索"
                    class="outline-none text-sm w-32 lg:w-44"
                >
            </form>

            @auth
                <a href="{{ route('cart.index') }}" class="relative">
                    <i data-lucide="shopping-cart" class="w-7 h-7"></i>
                    <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                    </span>
                </a>

                <div class="relative hidden lg:block">
                    <button id="userMenuButton"
                            type="button"
                            class="w-10 h-10 rounded-full bg-[#b8946d] text-white font-bold flex items-center justify-center">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </button>

                    <div id="userMenu"
                         class="hidden absolute right-0 mt-4 w-[280px] max-w-[calc(100vw-2rem)] bg-white border border-gray-200 rounded-2xl shadow-xl overflow-hidden z-50">
                        <div class="p-5 border-b">
                            <div class="font-bold">{{ auth()->user()->name }} 様</div>
                            <div class="text-sm text-gray-500 mt-1 break-all">{{ auth()->user()->email }}</div>
                        </div>

                        <div class="py-2 text-sm">
                            <a href="{{ route('mypage') }}"
                               class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                                <i data-lucide="user" class="w-5 h-5"></i>
                                マイページ
                            </a>

                            <a href="{{ route('cart.index') }}"
                               class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                                カート
                            </a>

                            <a href="{{ route('orders.index') }}"
                               class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                                <i data-lucide="receipt-text" class="w-5 h-5"></i>
                                注文履歴
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-5 py-3 text-red-500 hover:bg-red-50">
                                    <i data-lucide="log-out" class="w-5 h-5"></i>
                                    ログアウト
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="hidden sm:flex bg-[#070d16] text-white px-5 py-3 rounded-full text-sm font-bold">
                    ログイン
                </a>
            @endauth

            {{-- Mobile Hamburger --}}
            <button type="button"
                    id="siteMenuOpen"
                    class="lg:hidden w-11 h-11 rounded-full bg-[#070d16] text-white flex items-center justify-center">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Search --}}
    <div class="md:hidden px-4 pb-4">
        <form method="GET"
              action="{{ route('products.index') }}"
              class="flex items-center gap-2 border border-gray-200 rounded-full px-4 py-3 bg-white">
            <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
            <input
                name="keyword"
                value="{{ $keyword ?? '' }}"
                placeholder="人気商品を検索する"
                class="outline-none text-sm w-full"
            >
        </form>
    </div>
</header>

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
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                <span>ホーム</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>

            <a href="{{ route('products.all') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4  bg-gray-50 text-[#111827] font-bold">
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
                       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4  bg-gray-50 text-[#111827]  font-bold">
                        <span>カート</span>
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    </a>

                    <a href="{{ route('orders.index') }}"
                       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827]  font-bold">
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


</script>

</body>
</html>