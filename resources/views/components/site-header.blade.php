<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-[1500px] mx-auto h-16 md:h-20 px-4 md:px-8 flex items-center justify-between gap-4">

        <a href="{{ route('products.index') }}" class="text-2xl md:text-3xl font-bold shrink-0">
            ShopSwift
        </a>

        {{-- PC Nav --}}
     <nav class="hidden lg:flex items-center gap-8 text-sm font-bold">
    <a href="{{ route('products.index') }}"
       class="{{ request()->routeIs('products.index') ? 'text-[#b8946d]' : 'hover:text-gray-500' }}">
        ホーム
    </a>

    <a href="{{ route('products.all') }}"
       class="{{ request()->routeIs('products.all') || request()->routeIs('products.show') ? 'text-[#b8946d]' : 'hover:text-gray-500' }}">
        全商品を見る
    </a>

    <a href="{{ route('products.index') }}#products"
       class="hover:text-gray-500">
        人気商品
    </a>

    <a href="{{ route('articles.index') }}"
       class="{{ request()->routeIs('articles.*') ? 'text-[#b8946d]' : 'hover:text-gray-500' }}">
        Journal
    </a>

    <a href="{{ route('contact.index') }}"
       class="{{ request()->routeIs('contact.*') ? 'text-[#b8946d]' : 'hover:text-gray-500' }}">
        お問い合わせ
    </a>

    @auth
        @if (auth()->user()->is_admin)
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.*') ? 'text-[#b8946d]' : 'hover:text-gray-500' }}">
                管理画面
            </a>
        @endif

        <a href="{{ route('mypage') }}"
           class="{{ request()->routeIs('mypage') ? 'text-[#b8946d]' : 'hover:text-gray-500' }}">
            マイページ
        </a>

        <a href="{{ route('orders.index') }}"
           class="{{ request()->routeIs('orders.*') ? 'text-[#b8946d]' : 'hover:text-gray-500' }}">
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
                            class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
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

        @php
    $mobileActive = 'bg-[#070d16] text-white';
    $mobileNormal = 'bg-gray-50 text-[#111827]';
@endphp
<nav class="flex-1 px-6 py-7 space-y-2 overflow-y-auto">

    <a href="{{ route('products.index') }}"
       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('products.index') ? $mobileActive : $mobileNormal }}">
        <span>ホーム</span>
        <i data-lucide="arrow-right" class="w-5 h-5"></i>
    </a>

    <a href="{{ route('products.all') }}"
       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('products.all') || request()->routeIs('products.show') ? $mobileActive : $mobileNormal }}">
        <span>全商品を見る</span>
        <i data-lucide="arrow-right" class="w-5 h-5"></i>
    </a>

    <a href="{{ route('products.index') }}#products"
       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold">
        <span>人気商品</span>
        <i data-lucide="arrow-right" class="w-5 h-5"></i>
    </a>

    <a href="{{ route('articles.index') }}"
       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('articles.*') ? $mobileActive : $mobileNormal }}">
        <span>Journal</span>
        <i data-lucide="arrow-right" class="w-5 h-5"></i>
    </a>

    <a href="{{ route('contact.index') }}"
       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('contact.*') ? $mobileActive : $mobileNormal }}">
        <span>お問い合わせ</span>
        <i data-lucide="arrow-right" class="w-5 h-5"></i>
    </a>

    @auth
        <div class="pt-5 mt-5 border-t border-gray-100 space-y-2">

            @if (auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}"
                   class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('admin.*') ? $mobileActive : $mobileNormal }}">
                    <span>管理画面</span>
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                </a>
            @endif

            <a href="{{ route('mypage') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('mypage') ? $mobileActive : $mobileNormal }}">
                <span>マイページ</span>
                <i data-lucide="user" class="w-5 h-5"></i>
            </a>

            <a href="{{ route('cart.index') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('cart.*') ? $mobileActive : $mobileNormal }}">
                <span>カート</span>
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
            </a>

            <a href="{{ route('orders.index') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('orders.*') ? $mobileActive : $mobileNormal }}">
                <span>注文履歴</span>
                <i data-lucide="receipt-text" class="w-5 h-5"></i>
            </a>

        </div>
    @else
        <div class="pt-5 mt-5 border-t border-gray-100 space-y-2">
            <a href="{{ route('login') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('login') ? $mobileActive : $mobileNormal }}">
                <span>ログイン</span>
                <i data-lucide="user" class="w-5 h-5"></i>
            </a>

            <a href="{{ route('register') }}"
               class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 font-bold {{ request()->routeIs('register') ? $mobileActive : $mobileNormal }}">
                <span>新規登録</span>
                <i data-lucide="user-plus" class="w-5 h-5"></i>
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