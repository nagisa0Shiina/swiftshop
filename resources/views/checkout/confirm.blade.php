<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入確認 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

@php
    $freeShippingThreshold = 10000;
    $shippingBaseFee = 220;

    $calculatedSubtotal = isset($cartItems)
        ? $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        })
        : 0;

    $subtotal = $subtotal ?? $calculatedSubtotal;
    $shippingFee = $subtotal >= $freeShippingThreshold ? 0 : $shippingBaseFee;
    $total = $subtotal + $shippingFee;
    $remainingForFreeShipping = max($freeShippingThreshold - $subtotal, 0);
@endphp

<div class="w-full max-w-[1400px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

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
                   class="hover:text-gray-500">
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
                           class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-[#070d16] text-white font-bold">
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

    {{-- Main --}}
    <main class="w-full max-w-full px-4 sm:px-8 py-8 overflow-x-hidden">

        <div class="mb-8">

            <h1 class="text-3xl sm:text-4xl font-bold mb-3">
                購入確認
            </h1>

            <p class="text-gray-500">
                注文内容と配送先情報を確認してください。
            </p>

        </div>

        <a href="{{ route('cart.index') }}"
           class="flex items-center justify-center gap-3 w-full border border-gray-200 rounded-2xl py-4 mb-8 font-bold text-lg hover:bg-gray-50">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
            カートへ戻る
        </a>

        <form method="POST"
              action="{{ route('checkout.store') }}">

            @csrf

            @if ($errors->any())

                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-xl">

                    <div class="font-bold mb-2">
                        入力内容を確認してください
                    </div>

                    <ul class="list-disc list-inside space-y-1 text-sm">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Left --}}
                <div class="space-y-5 sm:space-y-6">

                    <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6">

                        <h2 class="text-2xl font-bold mb-5">
                            注文商品
                        </h2>

                        <div class="space-y-4">

                            @foreach ($cartItems as $cartItem)

                                <div class="border border-gray-200 rounded-2xl p-4 flex gap-4">

                                    <div
                                        class="bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0"
                                        style="width:96px; height:96px; min-width:96px; max-width:96px;"
                                    >

                                        @if ($cartItem->product->image_path)

                                            <img
                                                src="{{ asset('storage/' . $cartItem->product->image_path) }}"
                                                alt="{{ $cartItem->product->name }}"
                                                style="width:96px; height:96px; min-width:96px; max-width:96px; max-height:96px; object-fit:cover; object-position:center; display:block;"
                                            >

                                        @else

                                            <span class="text-3xl">
                                                📦
                                            </span>

                                        @endif

                                    </div>

                                    <div class="flex-1 min-w-0">

                                        <div class="text-lg sm:text-xl font-bold mb-2 break-words">
                                            {{ $cartItem->product->name }}
                                        </div>

                                        <div class="text-gray-500 text-sm mb-3">
                                            数量：{{ $cartItem->quantity }}
                                        </div>

                                        <div class="text-xl sm:text-2xl font-bold">
                                            ¥{{ number_format($cartItem->product->price * $cartItem->quantity) }}
                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

                {{-- Right --}}
                <div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-8 lg:sticky lg:top-6">

                        <h2 class="text-2xl font-bold mb-8">
                            注文サマリー
                        </h2>

                        <div class="space-y-5 text-base sm:text-lg">

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    商品小計
                                </span>

                                <span class="font-bold">
                                    ¥{{ number_format($subtotal) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    送料
                                </span>

                                <span class="font-bold">
                                    @if ($shippingFee > 0)
                                        ¥{{ number_format($shippingFee) }}
                                    @else
                                        無料
                                    @endif
                                </span>
                            </div>

                            <div class="rounded-2xl px-4 py-4 {{ $shippingFee > 0 ? 'bg-orange-50 text-orange-700' : 'bg-green-50 text-green-700' }}">
                                @if ($shippingFee > 0)
                                    <div class="font-bold">
                                        あと ¥{{ number_format($remainingForFreeShipping) }} で送料無料
                                    </div>

                                    <div class="text-sm mt-1">
                                        ¥{{ number_format($freeShippingThreshold) }}以上のご注文で送料無料になります。
                                    </div>
                                @else
                                    <div class="font-bold">
                                        送料無料が適用されています
                                    </div>

                                    <div class="text-sm mt-1">
                                        ¥{{ number_format($freeShippingThreshold) }}以上のご注文のため、送料は無料です。
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="border-t my-8"></div>

                        <div class="flex justify-between items-center mb-10">

                            <span class="text-xl sm:text-2xl font-bold">
                                合計
                            </span>

                            <span class="text-3xl sm:text-4xl font-bold">
                                ¥{{ number_format($total) }}
                            </span>

                        </div>

                        {{-- 配送先 --}}
                        <div class="border border-gray-200 rounded-2xl p-5 sm:p-6 mb-8">

                            <h3 class="text-2xl font-bold mb-6">
                                配送先情報
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

                                <div>

                                    <label class="block font-bold mb-2">
                                        お名前
                                    </label>

                                    <input
                                        type="text"
                                        name="customer_name"
                                        value="{{ old('customer_name', auth()->user()->name) }}"
                                        autocomplete="name"
                                        class="w-full border rounded-xl px-4 py-4 text-base
                                            @error('customer_name')
                                                border-red-500 bg-red-50
                                            @enderror"
                                    >

                                    @error('customer_name')

                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <div>

                                    <label class="block font-bold mb-2">
                                        メールアドレス
                                    </label>

                                    <input
                                        type="email"
                                        name="customer_email"
                                        value="{{ old('customer_email', auth()->user()->email) }}"
                                        autocomplete="email"
                                        class="w-full border rounded-xl px-4 py-4 text-base
                                            @error('customer_email')
                                                border-red-500 bg-red-50
                                            @enderror"
                                    >

                                    @error('customer_email')

                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <div>

                                    <label class="block font-bold mb-2">
                                        郵便番号
                                    </label>

                                    <input
                                        type="text"
                                        name="postal_code"
                                        value="{{ old('postal_code') }}"
                                        placeholder="123-4567"
                                        inputmode="numeric"
                                        autocomplete="postal-code"
                                        class="w-full border rounded-xl px-4 py-4 text-base
                                            @error('postal_code')
                                                border-red-500 bg-red-50
                                            @enderror"
                                    >

                                    @error('postal_code')

                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <div>

                                    <label class="block font-bold mb-2">
                                        電話番号
                                    </label>

                                    <input
                                        type="tel"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        placeholder="080-1234-5678"
                                        inputmode="tel"
                                        autocomplete="tel"
                                        pattern="0[789]0-?[0-9]{4}-?[0-9]{4}"
                                        class="w-full border rounded-xl px-4 py-4 text-base
                                            @error('phone')
                                                border-red-500 bg-red-50
                                            @enderror"
                                    >

                                    <p class="text-gray-400 text-xs mt-2">
                                        090 / 080 / 070 から始まる番号を入力できます。-は必要ございません。
                                    </p>

                                    @error('phone')

                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                            <div class="mt-6">

                                <label class="block font-bold mb-2">
                                    住所
                                </label>

                                <input
                                    type="text"
                                    name="address"
                                    value="{{ old('address') }}"
                                    autocomplete="street-address"
                                    class="w-full border rounded-xl px-4 py-4 text-base
                                        @error('address')
                                            border-red-500 bg-red-50
                                        @enderror"
                                >

                                @error('address')

                                    <div class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                        <button type="submit"
                                class="w-full bg-[#070d16] text-white py-5 rounded-xl text-lg sm:text-xl font-bold hover:bg-gray-800 transition">
                            Stripeで支払う
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </main>

</div>

<script>
    lucide.createIcons();

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

    /*
    |--------------------------------------------------------------------------
    | Mobile drawer
    |--------------------------------------------------------------------------
    */
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