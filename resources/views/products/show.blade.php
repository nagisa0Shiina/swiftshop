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

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-[1400px] mx-auto h-16 md:h-20 px-4 md:px-8 flex items-center justify-between gap-4">
        <a href="{{ route('products.index') }}" class="text-2xl md:text-3xl font-bold shrink-0">
            ShopSwift
        </a>

        <nav class="hidden lg:flex items-center gap-8 text-sm font-bold">
            <a href="{{ route('products.index') }}" class="hover:text-gray-500">ホーム</a>

            <a href="{{ route('products.all') }}"
               class="bg-[#070d16] text-white px-5 py-3 rounded-full hover:bg-gray-800">
                全商品一覧
            </a>

            <a href="{{ route('products.index') }}#products" class="hover:text-gray-500">人気商品</a>
            <a href="{{ route('products.index') }}#journal" class="hover:text-gray-500">Journal</a>

            @auth
                <a href="{{ route('mypage') }}" class="hover:text-gray-500">マイページ</a>
                <a href="{{ route('orders.index') }}" class="hover:text-gray-500">注文履歴</a>
            @endauth
        </nav>

        <div class="flex items-center gap-3 md:gap-5 shrink-0">
            @auth
                <a href="{{ route('cart.index') }}" class="relative">
                    <i data-lucide="shopping-cart" class="w-7 h-7"></i>
                    <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                    </span>
                </a>

                <div class="relative">
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

                <a href="{{ route('login') }}" class="sm:hidden">
                    <i data-lucide="user" class="w-7 h-7"></i>
                </a>
            @endauth
        </div>
    </div>
</header>

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
                    <span class="font-bold">¥3,000以上で無料</span>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-16 scroll-reveal">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <div class="text-gray-500 mb-2">ShopSwift Select</div>
                <h2 class="text-3xl font-bold">
                    あわせて見たい商品
                </h2>
            </div>

            <a href="{{ route('products.all') }}"
               class="hidden md:flex items-center gap-2 font-bold">
                全商品一覧へ
                <span>›</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-7">
            <a href="{{ route('products.all') }}"
               class="bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-lg transition">
                <div class="h-56 bg-[#f4eee6] flex items-center justify-center text-6xl">🪴</div>
                <div class="p-5">
                    <div class="text-sm text-gray-500 mb-2">ShopSwift Select</div>
                    <h3 class="font-bold text-lg mb-2">暮らしになじむアイテム</h3>
                    <p class="text-sm text-gray-500">全商品一覧からおすすめ商品をご覧ください。</p>
                </div>
            </a>

            <a href="{{ route('products.all') }}"
               class="bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-lg transition">
                <div class="h-56 bg-[#f4eee6] flex items-center justify-center text-6xl">☕</div>
                <div class="p-5">
                    <div class="text-sm text-gray-500 mb-2">Kitchen</div>
                    <h3 class="font-bold text-lg mb-2">キッチンアイテム</h3>
                    <p class="text-sm text-gray-500">毎日の時間を心地よく整えます。</p>
                </div>
            </a>

            <a href="{{ route('products.all') }}"
               class="bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-lg transition">
                <div class="h-56 bg-[#f4eee6] flex items-center justify-center text-6xl">🧺</div>
                <div class="p-5">
                    <div class="text-sm text-gray-500 mb-2">Storage</div>
                    <h3 class="font-bold text-lg mb-2">収納アイテム</h3>
                    <p class="text-sm text-gray-500">すっきりした暮らしに。</p>
                </div>
            </a>

            <a href="{{ route('products.all') }}"
               class="bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-lg transition">
                <div class="h-56 bg-[#f4eee6] flex items-center justify-center text-6xl">🕯️</div>
                <div class="p-5">
                    <div class="text-sm text-gray-500 mb-2">Relax</div>
                    <h3 class="font-bold text-lg mb-2">リラックスアイテム</h3>
                    <p class="text-sm text-gray-500">自分らしい時間を過ごすために。</p>
                </div>
            </a>
        </div>
    </section>

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

    const revealElements = document.querySelectorAll('.scroll-reveal');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, {
        threshold: 0.12
    });

    revealElements.forEach((element) => {
        revealObserver.observe(element);
    });

    document.querySelectorAll('form[action*="/cart"]').forEach((form) => {
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

    const cartToast = document.getElementById('cartToast');

    if (cartToast) {
        setTimeout(() => {
            cartToast.style.opacity = '0';
            cartToast.style.transform = 'translateY(-18px)';
            cartToast.style.transition = '.4s';

            setTimeout(() => {
                cartToast.remove();
            }, 400);
        }, 2500);
    }
        const favoriteActions = document.getElementById('favorite');

    if (favoriteActions) {
        setTimeout(() => {
            favoriteActions.style.opacity = '0';
            favoriteActions.style.transform = 'translateY(-18px)';
            favoriteActions.style.transition = '.4s';

            setTimeout(() => {
                cartToast.remove();
            }, 400);
        }, 2500);
    }
</script>

</body>
</html>