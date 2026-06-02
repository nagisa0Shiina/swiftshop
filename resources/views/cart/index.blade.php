<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カート | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden pb-20 md:pb-0">

@php
    $freeShippingThreshold = 10000;
    $shippingBaseFee = 220;

    $subtotal = isset($cartItems)
        ? $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        })
        : 0;

    $shippingFee = $subtotal > 0 && $subtotal < $freeShippingThreshold ? $shippingBaseFee : 0;
    $total = $subtotal + $shippingFee;
    $remainingForFreeShipping = max($freeShippingThreshold - $subtotal, 0);
@endphp

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-[1500px] mx-auto h-16 md:h-20 px-4 md:px-8 flex items-center justify-between gap-4">

        <a href="{{ route('products.index') }}" class="text-2xl md:text-3xl font-bold shrink-0">
            ShopSwift
        </a>

        {{-- PC Nav --}}
        <nav class="hidden lg:flex items-center gap-8 text-sm font-bold">
            <a href="{{ route('products.index') }}" class="hover:text-gray-500">
                ホーム
            </a>

            <a href="{{ route('products.all') }}" class="hover:text-gray-500">
                全商品を見る
            </a>

            <a href="{{ route('products.index') }}#products" class="hover:text-gray-500">
                人気商品
            </a>

            <a href="{{ route('articles.index') }}" class="hover:text-gray-500">
                Journal
            </a>

            <a href="{{ route('contact.index') }}" class="hover:text-gray-500">
                お問い合わせ
            </a>

            @auth
                <a href="{{ route('mypage') }}" class="hover:text-gray-500">
                    マイページ
                </a>

                <a href="{{ route('orders.index') }}" class="hover:text-gray-500">
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

<main class="max-w-[1400px] mx-auto px-4 sm:px-6 md:px-8 py-8 md:py-14">

    <div class="mb-10">
        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">
            カート
        </h1>

        <p class="text-gray-500 mt-4 text-base sm:text-lg">
            ご注文内容を確認して、購入手続きへお進みください。
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl">
            <div class="font-bold mb-2">
                確認してください
            </div>

            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if (isset($cartItems) && $cartItems->count() > 0)

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_420px] gap-8 items-start">

            {{-- Cart Items --}}
            <section class="space-y-5">

                @foreach ($cartItems as $cartItem)
                    <div class="bg-white border border-gray-200 rounded-3xl p-4 sm:p-6 shadow-sm">

                        <div class="flex flex-col sm:flex-row gap-5">

                            <a href="{{ route('products.show', $cartItem->product) }}"
                               class="w-full sm:w-36 h-56 sm:h-36 bg-[#f4eee6] rounded-2xl overflow-hidden shrink-0 flex items-center justify-center">

                                @if ($cartItem->product->image_path)
                                    <img src="{{ asset('storage/' . $cartItem->product->image_path) }}"
                                         alt="{{ $cartItem->product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-5xl">📦</span>
                                @endif

                            </a>

                            <div class="flex-1 min-w-0">

                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">

                                    <div>
                                        <div class="text-sm text-gray-400 font-bold mb-2">
                                            {{ $cartItem->product->category ?? 'ShopSwift Select' }}
                                        </div>

                                        <a href="{{ route('products.show', $cartItem->product) }}"
                                           class="block text-2xl font-bold leading-snug hover:text-gray-600 transition">
                                            {{ $cartItem->product->name }}
                                        </a>

                                        <div class="text-gray-500 mt-3 leading-relaxed">
                                            単価：¥{{ number_format($cartItem->product->price) }}
                                        </div>

                                        @if (! $cartItem->product->is_active)
                                            <div class="mt-3 inline-flex rounded-full bg-red-50 text-red-600 px-4 py-2 text-sm font-bold">
                                                販売停止中
                                            </div>
                                        @elseif ($cartItem->product->stock <= 0)
                                            <div class="mt-3 inline-flex rounded-full bg-red-50 text-red-600 px-4 py-2 text-sm font-bold">
                                                売り切れ
                                            </div>
                                        @elseif ($cartItem->quantity > $cartItem->product->stock)
                                            <div class="mt-3 inline-flex rounded-full bg-orange-50 text-orange-600 px-4 py-2 text-sm font-bold">
                                                在庫数を超えています
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-left md:text-right">
                                        <div class="text-sm text-gray-400 font-bold mb-2">
                                            小計
                                        </div>

                                        <div class="text-2xl font-bold">
                                            ¥{{ number_format($cartItem->product->price * $cartItem->quantity) }}
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                                    <form method="POST"
                                          action="{{ route('cart.update', $cartItem) }}"
                                          class="flex items-center gap-3">
                                        @csrf
                                        @method('PATCH')

                                        <label class="font-bold text-sm text-gray-500">
                                            数量
                                        </label>

                                        <input type="number"
                                               name="quantity"
                                               value="{{ $cartItem->quantity }}"
                                               min="1"
                                               max="{{ max($cartItem->product->stock, 1) }}"
                                               class="w-24 border border-gray-300 rounded-xl px-4 py-3 font-bold text-center">

                                        <button type="submit"
                                                class="rounded-xl border border-gray-300 px-5 py-3 font-bold hover:bg-gray-50 transition">
                                            更新
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('cart.destroy', $cartItem) }}"
                                          onsubmit="return confirm('この商品をカートから削除しますか？');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-50 text-red-500 px-5 py-3 font-bold hover:bg-red-100 transition">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            削除
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach

            </section>

            {{-- Summary --}}
            <aside class="bg-white border border-gray-200 rounded-3xl p-6 sm:p-8 shadow-sm lg:sticky lg:top-28">

                <h2 class="text-3xl font-bold mb-8">
                    注文サマリー
                </h2>

                <div class="mb-6 rounded-2xl border-2 border-[#070d16] bg-[#f8f4ef] px-5 py-4">
                    {{-- <div class="text-sm font-bold text-gray-500 mb-1">
                        送料ルール
                    </div> --}}

                    <div class="text-lg font-bold text-[#070d16]">
                        ¥10,000以上で送料無料 (通常送料¥220)
                    </div>
                </div>

                <div class="space-y-5 text-base sm:text-lg">

                    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                        <span class="text-gray-500">
                            商品小計
                        </span>

                        <span class="font-bold">
                            ¥{{ number_format($subtotal) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                        <span class="text-gray-500">
                            送料
                        </span>

                        <span class="font-bold {{ $shippingFee > 0 ? 'text-orange-600' : 'text-green-600' }}">
                            @if ($shippingFee > 0)
                                ¥{{ number_format($shippingFee) }}
                            @else
                                無料
                            @endif
                        </span>
                    </div>

                    @if ($shippingFee > 0)
                        <div class="rounded-2xl bg-orange-50 border border-orange-200 px-5 py-4 text-orange-700">
                            <div class="font-bold">
                                あと ¥{{ number_format($remainingForFreeShipping) }} で送料無料
                            </div>

                            <div class="text-sm mt-1 leading-6">
                                商品小計が ¥{{ number_format($freeShippingThreshold) }} 以上になると、送料¥220が無料になります。
                            </div>
                        </div>
                    @else
                        <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-4 text-green-700">
                            <div class="font-bold">
                                送料無料が適用されています
                            </div>

                            <div class="text-sm mt-1 leading-6">
                                商品小計が ¥{{ number_format($freeShippingThreshold) }} 以上のため、送料は無料です。
                            </div>
                        </div>
                    @endif

                </div>

                <div class="border-t my-8"></div>

                <div class="flex justify-between items-center mb-8">

                    <span class="text-xl sm:text-2xl font-bold">
                        合計
                    </span>

                    <span class="text-3xl sm:text-4xl font-bold">
                        ¥{{ number_format($total) }}
                    </span>

                </div>

                <a href="{{ route('checkout.confirm') }}"
                   class="w-full bg-[#070d16] text-white py-5 rounded-2xl text-lg font-bold hover:bg-gray-800 transition flex items-center justify-center gap-3">
                    購入手続きへ
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('products.all') }}"
                   class="mt-4 w-full border border-gray-300 py-4 rounded-2xl font-bold hover:bg-gray-50 transition flex items-center justify-center">
                    買い物を続ける
                </a>

            </aside>

        </div>

    @else

        <section class="bg-white border border-gray-200 rounded-3xl shadow-sm px-6 py-20 text-center">

            <div class="mx-auto w-20 h-20 rounded-full bg-[#f4eee6] flex items-center justify-center mb-8">
                <i data-lucide="shopping-cart" class="w-10 h-10 text-gray-500"></i>
            </div>

            <h2 class="text-3xl font-bold">
                カートは空です
            </h2>

            <p class="text-gray-500 mt-5 leading-8">
                気になる商品をカートに追加してから、購入手続きへお進みください。
            </p>

            <a href="{{ route('products.all') }}"
               class="mt-8 inline-flex items-center justify-center rounded-2xl bg-[#070d16] text-white px-8 py-4 font-bold hover:bg-gray-800 transition">
                商品を見る
            </a>

        </section>

    @endif

</main>

<footer class="border-t bg-white">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 md:px-8 py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 text-sm">
        <div>
            <div class="text-xl font-bold mb-4">ShopSwift</div>
            <p class="text-gray-600 leading-relaxed">
                暮らしを、もっと心地よく。<br>
                シンプルでやさしい毎日をお届けします。
            </p>
        </div>

        <div>
            <div class="font-bold mb-4">ショップ</div>
            <div class="space-y-2 text-gray-600">
                <a href="{{ route('products.all') }}" class="block hover:text-black">全商品一覧</a>
                <a href="{{ auth()->check() ? route('cart.index') : route('login') }}" class="block hover:text-black">カート</a>
                @auth
                    <a href="{{ route('mypage') }}" class="block hover:text-black">マイページ</a>
                    <a href="{{ route('orders.index') }}" class="block hover:text-black">注文履歴</a>
                @endauth
            </div>
        </div>

        <div>
            <div class="font-bold mb-4">サポート</div>

            <div class="space-y-2 text-gray-600">
                <a href="{{ route('contact.index') }}" class="block hover:text-black">
                    お問い合わせ
                </a>

                <a href="{{ route('terms') }}" class="block hover:text-black">
                    利用規約
                </a>

                <a href="{{ route('privacy') }}" class="block hover:text-black">
                    プライバシーポリシー
                </a>

                <a href="{{ route('commercial') }}" class="block hover:text-black">
                    特定商取引法に基づく表記
                </a>
            </div>
        </div>

        <div>
            <div class="font-bold mb-4">ShopSwiftについて</div>
            <div class="space-y-2 text-gray-600">
                <div>私たちについて</div>
                <div>サステナビリティ</div>
                <div>お知らせ</div>
            </div>
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

    @auth
        <a href="{{ route('mypage') }}" class="flex flex-col items-center justify-center gap-1">
            <i data-lucide="user" class="w-5 h-5"></i>
            マイページ
        </a>
    @else
        <a href="{{ route('login') }}" class="flex flex-col items-center justify-center gap-1">
            <i data-lucide="user" class="w-5 h-5"></i>
            ログイン
        </a>
    @endauth

    <a href="{{ auth()->check() ? route('cart.index') : route('login') }}"
       class="flex flex-col items-center justify-center gap-1 bg-[#070d16] text-white">
        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
        カート
    </a>
</nav>

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