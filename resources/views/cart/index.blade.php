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

<x-site-header />

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
                        ¥10,000以上で送料無料<br> (通常送料¥220)
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