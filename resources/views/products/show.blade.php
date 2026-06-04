<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .scroll-reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .scroll-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

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

<body class="bg-white text-[#111827] pb-20 md:pb-0 overflow-x-hidden">

@if (session('cart_success'))
    <div id="cartToast"
         class="toast-in fixed top-20 left-4 right-4 sm:left-auto sm:right-6 sm:w-[360px] z-[999] bg-white border border-gray-200 shadow-xl rounded-2xl px-5 py-4 flex items-center gap-3">
        <div class="w-9 h-9 shrink-0 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold">
            ✓
        </div>
        <div class="min-w-0">
            <div class="font-bold">カートに追加しました</div>
            <div class="text-sm text-gray-500 truncate">{{ session('cart_success') }}</div>
        </div>
    </div>
@endif
@if (session('success'))
    <div id="favorite" class="fixed top-20 left-4 right-4 sm:left-auto sm:right-6 sm:w-[360px] z-[999] bg-white border border-gray-200 shadow-xl rounded-2xl px-5 py-4">
        <div class="font-bold text-green-700">
            {{ session('success') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="fixed top-20 left-4 right-4 sm:left-auto sm:right-6 sm:w-[360px] z-[999] bg-white border border-red-200 shadow-xl rounded-2xl px-5 py-4 text-red-600">
        @foreach ($errors->all() as $error)
            <p class="text-sm font-bold">{{ $error }}</p>
        @endforeach
    </div>
@endif


<x-site-header />

<main class="max-w-[1400px] mx-auto px-4 sm:px-6 md:px-8 py-8 md:py-14">

    <nav class="mb-6 text-sm text-gray-500 flex flex-wrap items-center gap-2 scroll-reveal">
        <a href="{{ route('products.index') }}" class="hover:text-black">ホーム</a>
        <span>›</span>
        <a href="{{ route('products.all') }}" class="hover:text-black">全商品一覧</a>
        <span>›</span>
        <span class="text-black font-bold">{{ $product->name }}</span>
    </nav>

    <div class="mb-8 flex flex-col sm:flex-row gap-3 scroll-reveal">
        <a href="{{ route('products.all') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 border border-gray-300 rounded-xl font-bold hover:bg-gray-50 transition">
            <span>←</span>
            全商品一覧へ戻る
        </a>

        @auth
            <a href="{{ route('mypage') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 border border-gray-300 rounded-xl font-bold hover:bg-gray-50 transition">
                マイページへ
            </a>
        @endauth

        <a href="{{ route('products.index') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 border border-gray-300 rounded-xl font-bold hover:bg-gray-50 transition">
            トップページへ戻る
        </a>
    </div>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-10 md:gap-14 items-start mb-16 md:mb-24 scroll-reveal">
        <div>
            <div class="bg-[#f4eee6] rounded-3xl min-h-[280px] sm:min-h-[380px] md:min-h-[560px] flex items-center justify-center overflow-hidden">
                @if ($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="text-7xl md:text-9xl">📦</div>
                @endif
            </div>
        </div>

        <div class="lg:pt-6">
            <div class="inline-flex items-center gap-2 bg-[#f8f4ef] text-gray-700 rounded-full px-4 py-2 text-sm font-bold mb-6">
                {{ $product->category ?? 'ShopSwift Select' }}
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold leading-tight mb-6">
                {{ $product->name }}
            </h1>

            <div class="flex flex-wrap items-center gap-3 mb-6">
                <span class="text-yellow-400 tracking-widest">★★★★★</span>
                <span class="text-sm text-gray-500">4.6 / 128件のレビュー</span>
            </div>

            <div class="text-3xl md:text-4xl font-bold mb-8">
                ¥{{ number_format($product->price) }}
                <span class="text-sm text-gray-400 font-normal">税込</span>
            </div>

            <p class="text-gray-700 leading-loose text-base md:text-lg mb-8">
                {{ $product->description }}
            </p>

            @if (! $product->is_active)
                <div class="mb-8 bg-red-50 text-red-600 rounded-2xl px-5 py-4 font-bold">
                    販売停止中の商品です
                </div>
            @elseif ($product->stock <= 0)
                <div class="mb-8 bg-red-50 text-red-600 rounded-2xl px-5 py-4 font-bold">
                    売り切れの商品です
                </div>
            @else
                <div class="mb-8 bg-green-50 text-green-700 rounded-2xl px-5 py-4 font-bold">
                    在庫あり：{{ $product->stock }}点
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="border border-gray-200 rounded-2xl p-5">
                    <i data-lucide="truck" class="w-7 h-7 mb-4"></i>
                    <div class="font-bold mb-1">最短翌日発送</div>
                    <div class="text-sm text-gray-500 leading-relaxed">平日12時までの注文</div>
                </div>

                <div class="border border-gray-200 rounded-2xl p-5">
                    <i data-lucide="gift" class="w-7 h-7 mb-4"></i>
                    <div class="font-bold mb-1">ギフト対応</div>
                    <div class="text-sm text-gray-500 leading-relaxed">贈り物にもおすすめ</div>
                </div>

                <div class="border border-gray-200 rounded-2xl p-5">
                    <i data-lucide="shield-check" class="w-7 h-7 mb-4"></i>
                    <div class="font-bold mb-1">安心サポート</div>
                    <div class="text-sm text-gray-500 leading-relaxed">購入後も丁寧に対応</div>
                </div>
            </div>

            <div class="flex gap-4">
                {{-- <button type="button"
                        class="w-16 shrink-0 border border-gray-300 rounded-2xl flex items-center justify-center hover:bg-gray-50 transition">
                    <i data-lucide="heart" class="w-6 h-6"></i>
                </button> --}}
                    @auth
                    @php
                        $isFavorited = $product->favorites->contains('user_id', auth()->id());
                    @endphp

                    <form method="POST"
                        action="{{ route('favorites.toggle', $product) }}">
                        @csrf

                        <button type="submit"
                                class="w-16 h-full shrink-0 border rounded-2xl flex items-center justify-center transition
                                    {{ $isFavorited
                                        ? 'bg-red-50 border-red-200 text-red-500'
                                        : 'border-gray-300 hover:bg-gray-50 text-gray-700'
                                    }}">
                            <i data-lucide="heart"
                            class="w-6 h-6 {{ $isFavorited ? 'fill-current' : '' }}"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                    class="w-16 shrink-0 border border-gray-300 rounded-2xl flex items-center justify-center hover:bg-gray-50 transition">
                        <i data-lucide="heart" class="w-6 h-6"></i>
                    </a>
                @endauth
                @auth
                    <form method="POST"
                          action="{{ route('cart.store', $product) }}"
                          class="flex-1">
                        @csrf

                        <button type="submit"
                                class="w-full py-5 rounded-2xl font-bold transition flex items-center justify-center gap-3
                                    {{ (! $product->is_active || $product->stock <= 0)
                                        ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                        : 'bg-[#070d16] text-white hover:bg-gray-800'
                                    }}"
                                @if (! $product->is_active || $product->stock <= 0)
                                    disabled
                                @endif>
                            <i data-lucide="shopping-cart" class="w-6 h-6"></i>

                            @if (! $product->is_active)
                                販売停止中
                            @elseif ($product->stock <= 0)
                                売り切れ
                            @else
                                カートに入れる
                            @endif
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="flex-1 py-5 rounded-2xl bg-[#070d16] text-white font-bold hover:bg-gray-800 transition flex items-center justify-center">
                        ログインして購入
                    </a>
                @endauth
            </div>

            <div class="mt-6">
                <a href="{{ route('products.all') }}"
                   class="inline-flex items-center gap-2 text-sm font-bold text-gray-700 hover:underline">
                    <span>‹</span>
                    全商品一覧へ戻る
                </a>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16 md:mb-24 scroll-reveal">
        <div class="lg:col-span-2 bg-[#f8f4ef] rounded-3xl p-6 md:p-12">
            <h2 class="text-2xl md:text-3xl font-bold mb-6">
                商品について
            </h2>

            <div class="space-y-4 text-gray-700 leading-loose">
                <p>毎日の暮らしに自然となじむ、シンプルで使いやすいアイテムです。</p>
                <p>見た目の美しさだけでなく、使いやすさや長く愛用できる品質にもこだわっています。</p>
                <p>自分用にはもちろん、大切な方へのギフトにもおすすめです。</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8">
            <h2 class="text-2xl font-bold mb-6">
                商品情報
            </h2>

            <div class="space-y-4 text-sm">
                <div class="flex justify-between gap-4 border-b pb-3">
                    <span class="text-gray-500">カテゴリー</span>
                    <span class="font-bold text-right">{{ $product->category ?? '未分類' }}</span>
                </div>

                <div class="flex justify-between gap-4 border-b pb-3">
                    <span class="text-gray-500">在庫</span>
                    <span class="font-bold">{{ $product->stock }}点</span>
                </div>

                <div class="flex justify-between gap-4 border-b pb-3">
                    <span class="text-gray-500">配送</span>
                    <span class="font-bold">最短翌日発送</span>
                </div>

                <div class="flex justify-between gap-4">
                <span class="text-gray-500">送料</span>
                <span class="font-bold">¥10,000以上で無料 / 通常¥220</span>
            </div>
            </div>
        </div>
    </section>

@if (isset($relatedProducts) && $relatedProducts->count() > 0)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between gap-6 mb-8">
            <div>
                <p class="text-gray-500 font-bold mb-3">
                    ShopSwift Select
                </p>

                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight">
                    あわせて見たい商品
                </h2>
            </div>

            <a href="{{ route('products.all') }}"
               class="hidden sm:inline-flex items-center gap-2 font-bold hover:text-gray-500 transition">
                全商品一覧へ
                <i data-lucide="chevron-right" class="w-5 h-5"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($relatedProducts as $relatedProduct)
                <a href="{{ route('products.show', $relatedProduct) }}"
                   class="group bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition">

                    <div class="aspect-[4/3] bg-[#f4eee6] overflow-hidden">
                        @if ($relatedProduct->image_path)
                            <img
                                src="{{ asset('storage/' . $relatedProduct->image_path) }}"
                                alt="{{ $relatedProduct->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i data-lucide="image" class="w-12 h-12"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        @if ($relatedProduct->category)
                            <p class="text-sm text-gray-500 font-bold mb-2">
                                {{ $relatedProduct->category }}
                            </p>
                        @endif

                        <h3 class="text-lg font-bold leading-7 group-hover:text-[#b8946d] transition">
                            {{ $relatedProduct->name }}
                        </h3>

                        <p class="mt-3 text-gray-500 text-sm leading-7 line-clamp-2">
                            {{ $relatedProduct->description }}
                        </p>

                        <div class="mt-5 flex items-center justify-between gap-4">
                            <div class="text-xl font-bold">
                                ¥{{ number_format($relatedProduct->price) }}
                            </div>

                            <div class="w-10 h-10 rounded-full bg-[#070d16] text-white flex items-center justify-center group-hover:scale-110 transition">
                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8 sm:hidden">
            <a href="{{ route('products.all') }}"
               class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-[#070d16] text-white px-6 py-4 font-bold">
                全商品一覧へ
                <i data-lucide="chevron-right" class="w-5 h-5"></i>
            </a>
        </div>
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
       class="flex flex-col items-center justify-center gap-1">
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

    /*
    |--------------------------------------------------------------------------
    | Scroll reveal
    |--------------------------------------------------------------------------
    | これが無いと .scroll-reveal が opacity:0 のままで表示されない
    |--------------------------------------------------------------------------
    */
    const revealTargets = document.querySelectorAll('.scroll-reveal');

    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12
        });

        revealTargets.forEach((target) => {
            revealObserver.observe(target);
        });
    } else {
        revealTargets.forEach((target) => {
            target.classList.add('is-visible');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Toast auto hide
    |--------------------------------------------------------------------------
    */
    const cartToast = document.getElementById('cartToast');
    const favoriteToast = document.getElementById('favorite');

    if (cartToast) {
        setTimeout(() => {
            cartToast.style.opacity = '0';
            cartToast.style.transform = 'translateY(-16px)';
            cartToast.style.transition = 'opacity .3s ease, transform .3s ease';

            setTimeout(() => {
                cartToast.remove();
            }, 300);
        }, 2500);
    }

    if (favoriteToast) {
        setTimeout(() => {
            favoriteToast.style.opacity = '0';
            favoriteToast.style.transform = 'translateY(-16px)';
            favoriteToast.style.transition = 'opacity .3s ease, transform .3s ease';

            setTimeout(() => {
                favoriteToast.remove();
            }, 300);
        }, 2500);
    }
</script>

</body>
</html>