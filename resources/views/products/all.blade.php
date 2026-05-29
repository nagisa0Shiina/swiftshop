<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>全商品一覧 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
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

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-[1500px] mx-auto h-16 md:h-20 px-4 md:px-8 flex items-center justify-between gap-4">
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

            @auth
                <a href="{{ route('mypage') }}" class="hover:text-gray-500">マイページ</a>
                <a href="{{ route('orders.index') }}" class="hover:text-gray-500">注文履歴</a>
            @endauth
        </nav>

        <div class="flex items-center gap-3 md:gap-5 shrink-0">
            <form method="GET"
                  action="{{ route('products.all') }}"
                  class="hidden md:flex items-center gap-2 border border-gray-200 rounded-full px-4 py-2.5 bg-white">
                <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
                <input
                    name="keyword"
                    value="{{ $keyword ?? '' }}"
                    placeholder="検索する"
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

                <a href="{{ route('mypage') }}"
                   class="w-10 h-10 rounded-full bg-[#b8946d] text-white font-bold flex items-center justify-center hover:opacity-90">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </a>
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

    <div class="md:hidden px-4 pb-4">
        <form method="GET"
              action="{{ route('products.all') }}"
              class="flex items-center gap-2 border border-gray-200 rounded-full px-4 py-3 bg-white">
            <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
            <input
                name="keyword"
                value="{{ $keyword ?? '' }}"
                placeholder="商品を検索する"
                class="outline-none text-sm w-full"
            >
        </form>
    </div>
</header>

<main class="max-w-[1500px] mx-auto px-4 sm:px-6 md:px-8 py-10">

    <section class="mb-10">
        <div class="bg-[#f8f4ef] rounded-3xl p-8 md:p-12">
            <div class="text-gray-500 mb-3">All Products</div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                全商品一覧
            </h1>

            <p class="text-gray-600 leading-relaxed max-w-2xl">
                ShopSwiftで公開中の商品をすべてご覧いただけます。
                ログインしなくても商品詳細を見ることができます。
            </p>
        </div>
    </section>

    <section class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <form method="GET"
                  action="{{ route('products.all') }}"
                  class="flex w-full md:max-w-xl border border-gray-200 rounded-2xl overflow-hidden bg-white">
                <input
                    type="text"
                    name="keyword"
                    value="{{ $keyword ?? '' }}"
                    placeholder="商品名・説明・カテゴリで検索"
                    class="w-full px-5 py-4 outline-none"
                >

                <button type="submit"
                        class="bg-[#070d16] text-white px-5 flex items-center justify-center">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>
            </form>

            <div class="text-sm text-gray-500">
                @if ($products->total() > 0)
                    <span class="font-bold text-[#111827]">{{ $products->total() }}</span> 件の商品が見つかりました
                @else
                    商品が見つかりませんでした
                @endif
            </div>
        </div>
    </section>

    <section>
        @if ($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-7">
                @foreach ($products as $product)
                    <div class="group bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-500">

                        <a href="{{ route('products.show', $product) }}" class="block">
                            <div class="relative h-56 sm:h-64 bg-[#f4eee6] flex items-center justify-center overflow-hidden">
                                @if ($product->is_featured)
                                    <span class="absolute top-4 left-4 z-10 bg-black text-white rounded-full px-3 py-1 text-xs font-bold">
                                        人気商品
                                    </span>
                                @endif

                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                @else
                                    <div class="text-6xl">📦</div>
                                @endif
                            </div>

                            <div class="p-5">
                                <div class="text-sm text-gray-500 mb-2">
                                    {{ $product->category ?? 'ShopSwift Select' }}
                                </div>

                                <h2 class="font-bold text-lg mb-2 line-clamp-2">
                                    {{ $product->name }}
                                </h2>

                                <div class="font-bold text-xl mb-2">
                                    ¥{{ number_format($product->price) }}
                                    <span class="text-xs text-gray-400">税込</span>
                                </div>

                                <div class="text-yellow-400 text-sm mb-4">
                                    ★★★★★ <span class="text-gray-500">4.6</span>
                                </div>

                                <p class="text-sm text-gray-600 leading-relaxed line-clamp-2">
                                    {{ mb_strimwidth($product->description ?? '', 0, 70, '...') }}
                                </p>
                            </div>
                        </a>

                        <div class="px-5 pb-5 flex gap-3">
                            <a href="{{ route('products.show', $product) }}"
                               class="w-12 h-12 shrink-0 border border-gray-300 rounded-xl flex items-center justify-center hover:bg-gray-50 transition">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
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
                                            class="w-full h-12 bg-[#070d16] text-white rounded-xl font-bold hover:bg-gray-800 transition flex items-center justify-center gap-2 text-sm sm:text-base">
                                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                                        カートに入れる
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex-1 h-12 bg-[#070d16] text-white rounded-xl font-bold hover:bg-gray-800 transition flex items-center justify-center text-sm sm:text-base">
                                    ログインして購入
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <div class="bg-gray-50 border border-gray-200 rounded-3xl p-10 text-center">
                <div class="text-5xl mb-4">📦</div>
                <p class="font-bold text-lg mb-2">商品が見つかりませんでした</p>
                <p class="text-gray-500 text-sm mb-6">検索条件を変更してもう一度お試しください。</p>

                <a href="{{ route('products.all') }}"
                   class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#070d16] text-white font-bold">
                    全商品を表示する
                </a>
            </div>
        @endif
    </section>

</main>

<footer class="border-t bg-white">
    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 md:px-8 py-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-gray-500">
        <div class="font-bold text-[#111827] text-xl">
            ShopSwift
        </div>

        <div class="flex flex-wrap gap-4">
            <a href="{{ route('terms') }}" class="hover:text-black">
                利用規約
            </a>

            <a href="{{ route('privacy') }}" class="hover:text-black">
                プライバシーポリシー
            </a>

            <a href="{{ route('commercial') }}" class="hover:text-black">
                特定商取引法に基づく表記
            </a>

            <a href="{{ route('contact.index') }}" class="hover:text-black">
                お問い合わせ
            </a>
        </div>
    </div>
</footer>

<nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-gray-200 z-50 grid grid-cols-4 text-xs">
    <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="home" class="w-5 h-5"></i>
        ホーム
    </a>

    <a href="{{ route('products.all') }}" class="flex flex-col items-center justify-center gap-1 font-bold">
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



</script>

</body>
</html>