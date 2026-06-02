<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .toast-in {
            animation: toastIn .45s ease forwards;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(-16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-[#f5f6f7] text-[#111827] pb-20 md:pb-0 overflow-x-hidden">

@if (session('success'))
    <div id="successToast"
         class="toast-in fixed top-20 left-4 right-4 sm:left-auto sm:right-6 sm:w-[360px] z-[999] bg-white border border-gray-200 shadow-xl rounded-2xl px-5 py-4 flex items-center gap-3">
        <div class="w-9 h-9 shrink-0 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold">
            ✓
        </div>

        <div class="min-w-0">
            <div class="font-bold text-green-700">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

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
                       class="site-mobile-link flex items-center justify-between rounded-2xl px-5 py-4 bg-[#070d16] text-white font-bold">
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
        <section class="space-y-8">

            <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <div class="text-gray-500 mb-3">My Page</div>
                        <h1 class="text-3xl md:text-5xl font-bold mb-3">
                            マイページ
                        </h1>
                        <p class="text-gray-500">
                            いつもご利用いただきありがとうございます。
                        </p>
                    </div>

                    <a href="{{ route('products.all') }}"
                       class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white px-6 py-4 rounded-xl font-bold hover:bg-gray-800">
                        商品を探す
                        <span>→</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                <div class="bg-white border border-gray-200 rounded-3xl p-6">
                    <i data-lucide="shopping-bag" class="w-8 h-8 mb-5"></i>
                    <div class="text-sm text-gray-500 mb-2">注文回数</div>
                    <div class="text-3xl font-bold">{{ $orderCount }}回</div>
                </div>

                <div class="bg-white border border-gray-200 rounded-3xl p-6">
                    <i data-lucide="package" class="w-8 h-8 mb-5"></i>
                    <div class="text-sm text-gray-500 mb-2">購入商品数</div>
                    <div class="text-3xl font-bold">{{ $totalItems }}点</div>
                </div>

                <div class="bg-white border border-gray-200 rounded-3xl p-6">
                    <i data-lucide="yen" class="w-8 h-8 mb-5"></i>
                    <div class="text-sm text-gray-500 mb-2">累計購入金額</div>
                    <div class="text-3xl font-bold">¥{{ number_format($totalAmount) }}</div>
                </div>

                <div class="bg-white border border-gray-200 rounded-3xl p-6">
                    <i data-lucide="heart" class="w-8 h-8 mb-5"></i>
                    <div class="text-sm text-gray-500 mb-2">お気に入り</div>
                    <div class="text-3xl font-bold">{{ $favoriteCount }}件</div>
                </div>
            </div>

            <section id="favorites" class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">お気に入り商品</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            最近お気に入りに追加した商品を表示しています。
                        </p>
                    </div>

                    <a href="{{ route('products.all') }}"
                       class="inline-flex items-center justify-center gap-2 border border-gray-300 px-5 py-3 rounded-xl font-bold hover:bg-gray-50">
                        商品を探す
                        <span>→</span>
                    </a>
                </div>

                @if ($favoriteProducts->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                        @foreach ($favoriteProducts as $product)
                            <div class="group border border-gray-200 rounded-3xl overflow-hidden hover:shadow-lg transition bg-white">
                                <a href="{{ route('products.show', $product) }}" class="block">
                                    <div class="relative h-48 bg-[#f4eee6] flex items-center justify-center overflow-hidden">
                                        <span class="absolute top-4 left-4 z-10 bg-red-50 text-red-500 border border-red-100 rounded-full px-3 py-1 text-xs font-bold">
                                            お気に入り
                                        </span>

                                        @if ($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                        @else
                                            <div class="text-5xl">📦</div>
                                        @endif
                                    </div>

                                    <div class="p-5">
                                        <div class="text-sm text-gray-500 mb-2">
                                            {{ $product->category ?? 'ShopSwift Select' }}
                                        </div>

                                        <h3 class="font-bold text-lg mb-2 line-clamp-2">
                                            {{ $product->name }}
                                        </h3>

                                        <div class="font-bold text-xl">
                                            ¥{{ number_format($product->price) }}
                                            <span class="text-xs text-gray-400">税込</span>
                                        </div>
                                    </div>
                                </a>

                                <div class="px-5 pb-5 flex gap-3">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="w-12 h-12 shrink-0 border border-gray-300 rounded-xl flex items-center justify-center hover:bg-gray-50 transition">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('favorites.toggle', $product) }}">
                                        @csrf

                                        <button type="submit"
                                                class="w-12 h-12 shrink-0 border border-red-200 bg-red-50 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-100 transition">
                                            <i data-lucide="heart" class="w-5 h-5 fill-current"></i>
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('cart.store', $product) }}"
                                          class="flex-1">
                                        @csrf

                                        <button type="submit"
                                                class="w-full h-12 bg-[#070d16] text-white rounded-xl font-bold hover:bg-gray-800 transition flex items-center justify-center">
                                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-2xl p-8 text-center">
                        <div class="text-5xl mb-4">♡</div>
                        <p class="font-bold mb-2">お気に入り商品はまだありません</p>
                        <p class="text-sm text-gray-500 mb-6">
                            気になる商品を見つけたら、ハートボタンでお気に入りに追加できます。
                        </p>

                        <a href="{{ route('products.all') }}"
                           class="inline-flex bg-[#070d16] text-white px-6 py-3 rounded-xl font-bold">
                            商品を探す
                        </a>
                    </div>
                @endif
            </section>

            <div class="grid grid-cols-1 xl:grid-cols-[1fr_360px] gap-8">

                <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold">最近の注文</h2>
                            <p class="text-sm text-gray-500 mt-1">直近の注文を表示しています。</p>
                        </div>

                        <a href="{{ route('orders.index') }}"
                           class="text-sm font-bold hover:underline">
                            すべて見る →
                        </a>
                    </div>

                    @if ($recentOrders->count())
                        <div class="space-y-4">
                            @foreach ($recentOrders as $order)
                                <div class="border border-gray-100 rounded-2xl p-5">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                        <div>
                                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                                <span class="inline-flex px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold">
                                                    {{ $order->shipping_status ?? '確認中' }}
                                                </span>

                                                <span class="text-sm text-gray-500">
                                                    注文日：{{ $order->created_at->format('Y/m/d') }}
                                                </span>
                                            </div>

                                            <div class="font-bold text-lg">
                                                注文番号 #{{ $order->id }}
                                            </div>

                                            <div class="text-sm text-gray-500 mt-1">
                                                {{ $order->items->sum('quantity') }}点の商品
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <div class="text-xl font-bold">
                                                ¥{{ number_format($order->total_amount) }}
                                            </div>
                                            <div class="text-sm text-gray-500 mt-1">
                                                {{ $order->payment_status ?? '支払い確認中' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl p-8 text-center">
                            <div class="text-5xl mb-4">📦</div>
                            <p class="font-bold mb-2">まだ注文がありません</p>
                            <p class="text-sm text-gray-500 mb-6">
                                気になる商品を探して、はじめてのお買い物をしてみましょう。
                            </p>

                            <a href="{{ route('products.all') }}"
                               class="inline-flex bg-[#070d16] text-white px-6 py-3 rounded-xl font-bold">
                                商品を探す
                            </a>
                        </div>
                    @endif
                </div>

                <div class="space-y-8">

                    <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8">
                        <h2 class="text-2xl font-bold mb-6">プロフィール</h2>

                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-full bg-[#eadfd2] flex items-center justify-center text-2xl font-bold">
                                {{ mb_substr($user->name, 0, 1) }}
                            </div>

                            <div class="min-w-0">
                                <div class="font-bold text-xl truncate">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500 truncate">{{ $user->email }}</div>
                            </div>
                        </div>

                        <a href="{{ route('password.edit') }}"
                           class="block w-full text-center border border-gray-300 rounded-xl py-3 font-bold hover:bg-gray-50">
                            パスワードを変更する
                        </a>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8">
                        <h2 class="text-2xl font-bold mb-6">よく使うメニュー</h2>

                        <div class="grid grid-cols-2 gap-3">
                            <a href="#favorites"
                               class="border border-gray-200 rounded-2xl p-4 hover:bg-gray-50">
                                <i data-lucide="heart" class="w-6 h-6 mb-3"></i>
                                <div class="font-bold text-sm">お気に入り</div>
                            </a>

                            <a href="{{ route('orders.index') }}"
                               class="border border-gray-200 rounded-2xl p-4 hover:bg-gray-50">
                                <i data-lucide="receipt-text" class="w-6 h-6 mb-3"></i>
                                <div class="font-bold text-sm">注文履歴</div>
                            </a>

                            <a href="{{ route('cart.index') }}"
                               class="border border-gray-200 rounded-2xl p-4 hover:bg-gray-50">
                                <i data-lucide="shopping-cart" class="w-6 h-6 mb-3"></i>
                                <div class="font-bold text-sm">カート</div>
                            </a>

                            <a href="{{ route('products.all') }}"
                               class="border border-gray-200 rounded-2xl p-4 hover:bg-gray-50">
                                <i data-lucide="layout-grid" class="w-6 h-6 mb-3"></i>
                                <div class="font-bold text-sm">全商品</div>
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </section>

    </div>

</main>

<nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-gray-200 z-50 grid grid-cols-4 text-xs">
    <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="home" class="w-5 h-5"></i>
        ホーム
    </a>

    <a href="{{ route('products.all') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="layout-grid" class="w-5 h-5"></i>
        全商品
    </a>

    <a href="{{ route('orders.index') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="receipt-text" class="w-5 h-5"></i>
        注文
    </a>

    <a href="{{ route('mypage') }}" class="flex flex-col items-center justify-center gap-1 font-bold">
        <i data-lucide="user" class="w-5 h-5"></i>
        マイページ
    </a>
</nav>

<script>
    lucide.createIcons();

    document.querySelectorAll('form[action*="/cart"], form[action*="/favorites"]').forEach((form) => {
        form.addEventListener('submit', () => {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });
    });

    const savedScrollPosition = sessionStorage.getItem('scrollPosition');

    if (savedScrollPosition !== null) {
        window.scrollTo({
            top: parseInt(savedScrollPosition),
            behavior: 'instant'
        });

        sessionStorage.removeItem('scrollPosition');
    }

    const successToast = document.getElementById('successToast');

    if (successToast) {
        setTimeout(() => {
            successToast.style.opacity = '0';
            successToast.style.transform = 'translateY(-18px)';
            successToast.style.transition = '.4s';

            setTimeout(() => {
                successToast.remove();
            }, 400);
        }, 2500);
    }
</script>

</body>
</html>