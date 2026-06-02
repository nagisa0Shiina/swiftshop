<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショッピングカート | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="w-full max-w-[1500px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

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
                   class="hover:text-gray-500 bg-[#070d16] text-white px-5 py-3 rounded-full">
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
                       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-gray-50 text-[#111827] font-bold">
                        <span>カート</span>
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    </a>

                    <a href="{{ route('orders.index') }}"
                       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-[#070d16] text-white font-bold">
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
                       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-[#070d16] text-white font-bold">
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

    <main class="w-full max-w-full px-4 sm:px-8 py-8 overflow-x-hidden">

        <div class="mb-8">

            <h1 class="text-3xl sm:text-2xl font-bold mb-3">
                ショッピングカート
            </h1>

            <p class="text-gray-500">
                カート内の商品を確認できます。
            </p>

        </div>

        <a href="{{ route('products.index') }}"
           class="flex items-center justify-center gap-3 w-full border border-gray-200 rounded-2xl py-4 mb-8 font-bold text-lg hover:bg-gray-50">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
            買い物を続ける
        </a>

        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-700 px-5 py-4 rounded-xl">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if ($cartItems->isEmpty())

            <div class="bg-white border border-gray-200 rounded-2xl p-10 sm:p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gray-100 flex items-center justify-center">
                    <i data-lucide="shopping-cart" class="w-8 h-8 text-gray-400"></i>
                </div>

                <p class="text-gray-500 mb-6">
                    カートは空です。
                </p>

                <a href="{{ route('products.index') }}"
                   class="inline-block bg-[#070d16] text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                    商品一覧へ戻る
                </a>
            </div>

        @else

            @php
                $hasUnavailableItems = $cartItems->contains(function ($item) {
                    return ! $item->product->is_active || $item->product->stock <= 0;
                });
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 min-w-0 space-y-6">

                    {{-- スマホ表示 --}}
                    <div class="lg:hidden space-y-6">

                        @foreach ($cartItems as $item)

                            @php
                                $isUnavailable = ! $item->product->is_active || $item->product->stock <= 0;
                            @endphp

                            <div class="bg-white border border-gray-200 rounded-2xl p-5 overflow-hidden {{ $isUnavailable ? 'bg-red-50/40' : '' }}">

                                <div class="flex items-start gap-4">

                                    {{-- 商品画像：カートでは絶対に小さいサムネ固定 --}}
                                    <div
                                        class="bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0"
                                        style="width:112px; height:96px; min-width:112px; max-width:112px;"
                                    >
                                        @if ($item->product->image_path)
                                            <img
                                                src="{{ asset('storage/' . $item->product->image_path) }}"
                                                alt="{{ $item->product->name }}"
                                                class="{{ $isUnavailable ? 'opacity-40 grayscale' : '' }}"
                                                style="width:112px; height:96px; min-width:112px; max-width:112px; max-height:96px; object-fit:cover; object-position:center; display:block;"
                                            >
                                        @else
                                            <span class="text-3xl {{ $isUnavailable ? 'opacity-40 grayscale' : '' }}">
                                                @if (str_contains($item->product->name, 'マグ') || str_contains($item->product->name, 'カップ'))
                                                    ☕
                                                @elseif (str_contains($item->product->name, 'ディフューザー'))
                                                    🧴
                                                @elseif (str_contains($item->product->name, 'バッグ'))
                                                    👜
                                                @elseif (str_contains($item->product->name, 'ウォッチ') || str_contains($item->product->name, '時計'))
                                                    ⌚
                                                @else
                                                    📦
                                                @endif
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">

                                        <div class="flex items-start justify-between gap-3">

                                            <div class="min-w-0">
                                                <div class="font-bold text-2xl leading-tight break-words">
                                                    {{ $item->product->name }}
                                                </div>

                                                <div class="text-gray-500 text-lg mt-2">
                                                    ¥{{ number_format($item->product->price) }}
                                                </div>

                                                @if (! $item->product->is_active)
                                                    <div class="text-red-500 text-sm font-bold mt-2">
                                                        販売停止中の商品です
                                                    </div>
                                                @elseif ($item->product->stock <= 0)
                                                    <div class="text-red-500 text-sm font-bold mt-2">
                                                        売り切れの商品です
                                                    </div>
                                                @else
                                                    <div class="text-gray-500 text-lg mt-2">
                                                        在庫：{{ $item->product->stock }}
                                                    </div>
                                                @endif
                                            </div>

                                            <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="w-12 h-12 rounded-full bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-500 flex items-center justify-center shrink-0">
                                                    <i data-lucide="x" class="w-6 h-6"></i>
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                </div>

                                <form
                                    method="POST"
                                    action="{{ route('cart.update', $item) }}"
                                    class="mt-6 border-t border-gray-100 pt-6"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <div class="text-center text-gray-500 font-bold mb-3">
                                        数量
                                    </div>

                                    <div class="max-w-sm mx-auto border border-gray-200 rounded-2xl p-2 flex items-center justify-between bg-white">

                                        <button type="button"
                                                class="quantity-minus w-14 h-14 rounded-xl border border-gray-200 flex items-center justify-center text-2xl font-bold hover:bg-gray-50 disabled:bg-gray-100 disabled:text-gray-400"
                                                data-target="quantity-{{ $item->id }}"
                                                @if ($isUnavailable) disabled @endif>
                                            −
                                        </button>

                                        <input
                                            id="quantity-{{ $item->id }}"
                                            type="number"
                                            name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            max="{{ max($item->product->stock, 1) }}"
                                            class="w-20 h-14 text-center text-2xl font-bold border-0 bg-transparent focus:ring-0 focus:outline-none {{ $isUnavailable ? 'text-gray-400 cursor-not-allowed' : '' }}"
                                            @if ($isUnavailable)
                                                disabled
                                            @endif
                                        >

                                        <button type="button"
                                                class="quantity-plus w-14 h-14 rounded-xl border border-gray-200 flex items-center justify-center text-3xl font-bold hover:bg-gray-50 disabled:bg-gray-100 disabled:text-gray-400"
                                                data-target="quantity-{{ $item->id }}"
                                                @if ($isUnavailable) disabled @endif>
                                            +
                                        </button>

                                    </div>

                                    <button type="submit"
                                            class="max-w-sm mx-auto mt-4 w-full h-14 rounded-2xl text-base font-bold flex items-center justify-center gap-2
                                                {{ $isUnavailable
                                                    ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                                    : 'bg-[#070d16] text-white hover:bg-gray-800'
                                                }}"
                                            @if ($isUnavailable)
                                                disabled
                                            @endif>
                                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                                        更新
                                    </button>

                                </form>

                                <div class="mt-5 bg-gray-50 rounded-2xl px-5 py-5 text-right">
                                    <div class="text-gray-500 mb-2">
                                        小計
                                    </div>

                                    <div class="text-2xl font-bold">
                                        ¥{{ number_format($item->product->price * $item->quantity) }}
                                    </div>
                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- PC表示 --}}
                    <div class="hidden lg:block bg-white border border-gray-200 rounded-2xl overflow-hidden">

                        <table class="w-full border-collapse">

                            <thead>
                                <tr class="border-b text-sm text-gray-500 bg-gray-50">
                                    <th class="text-left px-6 py-4">商品</th>
                                    <th class="text-right px-6 py-4">価格</th>
                                    <th class="text-center px-6 py-4">数量</th>
                                    <th class="text-right px-6 py-4">小計</th>
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($cartItems as $item)

                                    @php
                                        $isUnavailable = ! $item->product->is_active || $item->product->stock <= 0;
                                    @endphp

                                    <tr class="border-b last:border-b-0 {{ $isUnavailable ? 'bg-red-50/40' : '' }}">

                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="bg-gray-100 rounded-md flex items-center justify-center overflow-hidden shrink-0"
                                                    style="width:64px; height:64px; min-width:64px; max-width:64px;"
                                                >
                                                    @if ($item->product->image_path)
                                                        <img
                                                            src="{{ asset('storage/' . $item->product->image_path) }}"
                                                            alt="{{ $item->product->name }}"
                                                            class="{{ $isUnavailable ? 'opacity-40 grayscale' : '' }}"
                                                            style="width:64px; height:64px; min-width:64px; max-width:64px; max-height:64px; object-fit:cover; object-position:center; display:block;"
                                                        >
                                                    @else
                                                        <span class="text-2xl {{ $isUnavailable ? 'opacity-40 grayscale' : '' }}">
                                                            📦
                                                        </span>
                                                    @endif
                                                </div>

                                                <div>
                                                    <div class="font-bold">
                                                        {{ $item->product->name }}
                                                    </div>

                                                    @if (! $item->product->is_active)
                                                        <div class="text-red-500 text-sm font-bold mt-1">
                                                            販売停止中の商品です
                                                        </div>
                                                    @elseif ($item->product->stock <= 0)
                                                        <div class="text-red-500 text-sm font-bold mt-1">
                                                            売り切れの商品です
                                                        </div>
                                                    @else
                                                        <div class="text-gray-500 text-sm mt-1">
                                                            在庫：{{ $item->product->stock }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-5 text-right text-sm whitespace-nowrap">
                                            ¥{{ number_format($item->product->price) }}
                                        </td>

                                        <td class="px-6 py-5">
                                            <form method="POST"
                                                  action="{{ route('cart.update', $item) }}"
                                                  class="flex items-center justify-center gap-2">
                                                @csrf
                                                @method('PATCH')

                                                <input
                                                    type="number"
                                                    name="quantity"
                                                    value="{{ $item->quantity }}"
                                                    min="1"
                                                    max="{{ max($item->product->stock, 1) }}"
                                                    class="w-16 h-9 border rounded-md text-center text-sm {{ $isUnavailable ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}"
                                                    @if ($isUnavailable)
                                                        disabled
                                                    @endif
                                                >

                                                <button type="submit"
                                                        class="w-12 h-9 rounded-md text-xs
                                                            {{ $isUnavailable
                                                                ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                                                : 'bg-[#070d16] text-white hover:bg-gray-800'
                                                            }}"
                                                        @if ($isUnavailable)
                                                            disabled
                                                        @endif>
                                                    更新
                                                </button>
                                            </form>
                                        </td>

                                        <td class="px-6 py-5 text-right font-bold text-sm whitespace-nowrap">
                                            ¥{{ number_format($item->product->price * $item->quantity) }}
                                        </td>

                                        <td class="px-6 py-5 text-right">
                                            <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="text-gray-500 hover:text-red-500">
                                                    <i data-lucide="x" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

                <aside class="bg-white border border-gray-200 rounded-2xl p-6 h-fit lg:sticky lg:top-8">

                    <h2 class="text-3xl font-bold mb-6">
                        注文内容
                    </h2>

                    <div class="space-y-4 border-b pb-5 mb-5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">小計</span>
                            <span class="font-bold">¥{{ number_format($total) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">送料</span>
                            <span class="font-bold">無料</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg font-bold">合計</span>
                        <span class="text-3xl font-bold">¥{{ number_format($total) }}</span>
                    </div>

                    @if ($hasUnavailableItems)

                        <button disabled
                                class="block w-full text-center bg-gray-300 text-gray-500 py-4 rounded-xl font-bold cursor-not-allowed">
                            購入できない商品が含まれています
                        </button>

                    @else

                        <a href="{{ route('checkout.confirm') }}"
                           class="block w-full text-center bg-[#070d16] text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                            ご購入手続きへ
                        </a>

                    @endif

                    <a href="{{ route('products.index') }}"
                       class="block text-center mt-4 text-blue-500 text-sm">
                        ショッピングを続ける
                    </a>

                </aside>

            </div>

        @endif

    </main>

</div>

<script>
    lucide.createIcons();

    document.querySelectorAll('.quantity-minus').forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.getElementById(button.dataset.target);

            if (! target) return;

            const min = Number(target.min || 1);
            const current = Number(target.value || min);

            if (current > min) {
                target.value = current - 1;
            }
        });
    });

    document.querySelectorAll('.quantity-plus').forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.getElementById(button.dataset.target);

            if (! target) return;

            const max = Number(target.max || 999);
            const current = Number(target.value || 1);

            if (current < max) {
                target.value = current + 1;
            }
        });
    });
</script>

</body>
</html>