<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f8f8f5] text-[#1f2933] overflow-x-hidden">
<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-[1500px] mx-auto h-16 md:h-20 px-4 md:px-8 flex items-center justify-between gap-4">

        <a href="{{ route('products.index') }}" class="text-2xl md:text-3xl font-bold shrink-0">
            ShopSwift
        </a>

        {{-- PC Nav --}}
        <nav class="hidden lg:flex items-center gap-8 text-sm font-bold">
            <a href="{{ route('products.index') }}"
               class="hover:text-gray-500 ">
                ホーム
            </a>

            <a href="{{ route('products.all') }}"
               class="hover:text-gray-500">
                全商品を見る
            </a>

            <a href="{{ route('products.index') }}#products"
               class="hover:text-gray-500">
                人気商品
            </a>

            <a href="{{ route('articles.index') }}"
               class="hover:text-gray-500 bg-[#070d16] text-white px-5 py-3 rounded-full">
                Journal
            </a>

            <a href="{{ route('contact.index') }}"
               class="hover:text-gray-500 ">
                お問い合わせ
            </a>

            @auth
                        @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                    class="hover:text-gray-500">
                        管理画面
                    </a>
                @endif
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
                               @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                    class="hover:text-gray-500">
                        管理画面
                    </a>
                @endif
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
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-[#070d16] text-white  font-bold">
                <span>Journal</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>

            <a href="{{ route('contact.index') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                <span>お問い合わせ</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>

            @auth
                               @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                    class="hover:text-gray-500">
                        管理画面
                    </a>
                @endif
                
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

<main>

    <section class="relative overflow-hidden bg-[#eef1e7]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 py-20 sm:py-24 lg:py-28">

            <div class="max-w-3xl">
                <p class="text-[#6f7f55] font-bold tracking-[0.25em] text-sm mb-6">
                    JOURNAL
                </p>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight leading-tight">
                    暮らしを少し心地よくする読みもの
                </h1>

                <p class="mt-8 text-gray-600 text-base sm:text-lg leading-9">
                    商品の選び方、暮らしの整え方、お知らせなどをお届けします。
                    ShopSwiftでのお買い物がもっと楽しくなる情報をまとめました。
                </p>
            </div>

        </div>

        <div class="absolute right-[-120px] bottom-[-160px] w-[420px] h-[420px] rounded-full bg-white/50"></div>
    </section>

    <section class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 py-16 sm:py-20 lg:py-24">

        @if ($articles->count() > 0)

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                @foreach ($articles as $article)
                    <article class="group bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden hover:-translate-y-1 hover:shadow-md transition duration-300">

                        <a href="{{ route('articles.show', $article) }}" class="block">

                            <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">

                                @if ($article->thumbnail_path)
                                    <img src="{{ asset('storage/' . $article->thumbnail_path) }}"
                                         alt="{{ $article->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#eef1e7] to-[#dfe5d3] flex items-center justify-center">
                                        <i data-lucide="newspaper" class="w-16 h-16 text-[#6f7f55]"></i>
                                    </div>
                                @endif

                                <div class="absolute top-5 left-5">
                                    <span class="inline-flex rounded-full bg-white/90 px-4 py-2 text-xs font-bold text-[#6f7f55] shadow-sm">
                                        Journal
                                    </span>
                                </div>

                            </div>

                            <div class="p-7 sm:p-8">

                                <div class="flex items-center gap-2 text-gray-400 text-sm font-bold mb-5">
                                    <i data-lucide="calendar-days" class="w-4 h-4"></i>
                                    <span>
                                        {{ optional($article->published_at ?? $article->created_at)->format('Y.m.d') }}
                                    </span>
                                </div>

                                <h2 class="text-2xl font-bold leading-snug group-hover:text-[#6f7f55] transition">
                                    {{ $article->title }}
                                </h2>

                                <p class="mt-5 text-gray-600 leading-8 text-base">
                                    @if (!empty($article->excerpt))
                                        {{ $article->excerpt }}
                                    @else
                                        {{ Str::limit(strip_tags($article->body), 90) }}
                                    @endif
                                </p>

                                <div class="mt-8 inline-flex items-center gap-2 text-[#6f7f55] font-bold">
                                    続きを読む
                                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition"></i>
                                </div>

                            </div>

                        </a>

                    </article>
                @endforeach

            </div>

            @if (method_exists($articles, 'links'))
                <div class="mt-14">
                    {{ $articles->links() }}
                </div>
            @endif

        @else

            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm px-6 py-20 text-center">

                <div class="mx-auto w-20 h-20 rounded-full bg-[#eef1e7] flex items-center justify-center mb-8">
                    <i data-lucide="newspaper" class="w-10 h-10 text-[#6f7f55]"></i>
                </div>

                <h2 class="text-3xl font-bold">
                    記事はまだありません
                </h2>

                <p class="mt-5 text-gray-500 leading-8">
                    公開された記事がここに表示されます。
                </p>

                <a href="{{ route('products.index') }}"
                   class="mt-8 inline-flex items-center justify-center rounded-full bg-[#1f2933] text-white px-8 py-4 font-bold hover:bg-[#6f7f55] transition">
                    トップへ戻る
                </a>

            </div>

        @endif

    </section>

</main>

<footer class="bg-[#1f2933] text-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 py-12">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="text-2xl font-bold">ShopSwift</div>
                <p class="text-white/50 mt-3">暮らしに寄り添うオンラインストア</p>
            </div>

            <div class="flex flex-wrap gap-5 text-sm text-white/70 font-bold">
                <a href="{{ route('terms') }}" class="hover:text-white transition">利用規約</a>
                <a href="{{ route('privacy') }}" class="hover:text-white transition">プライバシーポリシー</a>
                <a href="{{ route('commercial') }}" class="hover:text-white transition">特定商取引法</a>
                <a href="{{ route('contact.index') }}" class="hover:text-white transition">お問い合わせ</a>
            </div>
        </div>
    </div>
</footer>

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


    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');

    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function () {
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }

</script>

</body>
</html>