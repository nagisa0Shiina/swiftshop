<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事一覧 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="w-full max-w-[1500px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

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

    <main class="w-full max-w-full px-4 sm:px-8 py-8 overflow-x-hidden">

        <section class="mb-10 sm:mb-12">

            <div class="max-w-3xl">

                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full text-sm font-bold text-gray-500 mb-5">
                    <i data-lucide="newspaper" class="w-4 h-4"></i>
                    ShopSwift Journal
                </div>

                <h1 class="text-3xl sm:text-5xl font-bold leading-tight mb-4">
                    記事一覧
                </h1>

                <p class="text-gray-500 text-base sm:text-lg leading-relaxed">
                    お知らせ・商品紹介・ECサイト運営に関する情報をお届けします。
                </p>

            </div>

        </section>

        @if ($articles->isEmpty())

            <div class="bg-white border border-gray-200 rounded-2xl p-10 sm:p-12 text-center">

                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gray-100 flex items-center justify-center">
                    <i data-lucide="newspaper" class="w-8 h-8 text-gray-400"></i>
                </div>

                <p class="text-gray-500 mb-6">
                    公開中の記事はまだありません。
                </p>

                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    ホームへ戻る
                </a>

            </div>

        @else

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach ($articles as $article)

                    <article class="bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-sm transition">

                        <a href="{{ route('articles.show', $article) }}" class="block">

                            <div class="aspect-video bg-gray-100 overflow-hidden">

                                @if ($article->thumbnail_path)

                                    <img
                                        src="{{ asset('storage/' . $article->thumbnail_path) }}"
                                        alt="{{ $article->title }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="newspaper" class="w-12 h-12 text-gray-300"></i>
                                    </div>

                                @endif

                            </div>

                            <div class="p-5 sm:p-6">

                                <div class="text-sm text-gray-400 mb-3">
                                    {{ optional($article->published_at)->format('Y/m/d') ?? $article->created_at->format('Y/m/d') }}
                                </div>

                                <h2 class="text-xl font-bold leading-relaxed mb-3 break-words">
                                    {{ $article->title }}
                                </h2>

                                <p class="text-gray-500 text-sm leading-relaxed mb-5">
                                    {{ $article->excerpt ?: Str::limit(strip_tags($article->body), 90) }}
                                </p>

                                <div class="inline-flex items-center gap-2 font-bold text-sm">
                                    続きを読む
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </div>

                            </div>

                        </a>

                    </article>

                @endforeach

            </div>

            <div class="mt-10 overflow-x-auto">
                {{ $articles->links() }}
            </div>

        @endif

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>