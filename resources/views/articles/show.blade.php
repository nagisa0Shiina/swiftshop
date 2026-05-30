<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="w-full max-w-[1200px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

    <header class="sticky top-0 z-40 bg-white h-16 sm:h-20 px-4 sm:px-8 flex items-center justify-between border-b border-gray-100">

        <a href="{{ route('products.index') }}" class="text-xl sm:text-2xl font-bold">
            ShopSwift
        </a>

        <nav class="hidden lg:flex items-center gap-10 text-sm font-medium">
            <a href="{{ route('products.index') }}" class="hover:text-gray-500">
                ホーム
            </a>

            <a href="{{ route('products.all') }}" class="hover:text-gray-500">
                商品一覧
            </a>

            <a href="{{ route('articles.index') }}" class="font-bold">
                記事一覧
            </a>

            @auth
                <a href="{{ route('orders.index') }}" class="hover:text-gray-500">
                    注文履歴
                </a>

                <a href="{{ route('mypage') }}" class="hover:text-gray-500">
                    マイページ
                </a>
            @endauth
        </nav>

        <div class="flex items-center gap-5 sm:gap-6">

            @auth
                <a href="{{ route('cart.index') }}" class="relative">
                    <i data-lucide="shopping-cart" class="w-7 h-7 sm:w-6 sm:h-6"></i>

                    <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                    </span>
                </a>

                <a href="{{ route('mypage') }}">
                    <i data-lucide="user" class="w-7 h-7 sm:w-6 sm:h-6"></i>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl border border-gray-200 font-bold text-sm hover:bg-gray-50">
                    ログイン
                </a>
            @endauth

        </div>

    </header>

    <main class="w-full max-w-full px-4 sm:px-8 py-8 sm:py-10 overflow-x-hidden">

        <a href="{{ route('articles.index') }}"
           class="inline-flex items-center justify-center gap-2 border border-gray-200 rounded-2xl px-5 py-3 font-bold hover:bg-gray-50 mb-8">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            記事一覧へ戻る
        </a>

        <article>

            <header class="mb-8 sm:mb-10">

                <div class="text-sm text-gray-400 mb-4">
                    {{ optional($article->published_at)->format('Y/m/d') ?? $article->created_at->format('Y/m/d') }}
                </div>

                <h1 class="text-3xl sm:text-5xl font-bold leading-tight break-words mb-5">
                    {{ $article->title }}
                </h1>

                @if ($article->excerpt)

                    <p class="text-gray-500 text-base sm:text-lg leading-relaxed">
                        {{ $article->excerpt }}
                    </p>

                @endif

            </header>

            <div class="rounded-3xl overflow-hidden bg-gray-100 mb-8 sm:mb-10 border border-gray-200">

                @if ($article->thumbnail_path)

                    <img
                        src="{{ asset('storage/' . $article->thumbnail_path) }}"
                        alt="{{ $article->title }}"
                        class="w-full max-h-[520px] object-cover"
                    >

                @else

                    <div class="aspect-video flex items-center justify-center">
                        <i data-lucide="newspaper" class="w-16 h-16 text-gray-300"></i>
                    </div>

                @endif

            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-5 sm:p-8">

                <div class="prose max-w-none">

                    @foreach (preg_split("/\r\n|\n|\r/", $article->body) as $paragraph)

                        @if (trim($paragraph) !== '')

                            <p class="text-base sm:text-lg leading-9 text-gray-700 mb-6 break-words">
                                {{ $paragraph }}
                            </p>

                        @endif

                    @endforeach

                </div>

            </div>

        </article>

        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-3">

            <a href="{{ route('articles.index') }}"
               class="inline-flex items-center justify-center gap-2 border border-gray-200 rounded-2xl px-6 py-4 font-bold hover:bg-gray-50">
                <i data-lucide="newspaper" class="w-5 h-5"></i>
                記事一覧へ戻る
            </a>

            <a href="{{ route('products.all') }}"
               class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white rounded-2xl px-6 py-4 font-bold hover:bg-gray-800 transition">
                <i data-lucide="package" class="w-5 h-5"></i>
                商品一覧を見る
            </a>

        </div>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>