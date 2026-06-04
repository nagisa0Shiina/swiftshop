<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f8f8f5] text-[#1f2933] overflow-x-hidden">

<x-site-header />

<main>

    <section class="relative overflow-hidden bg-[#eef1e7]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 py-20 sm:py-24 lg:py-28">

            <div class="max-w-3xl">
                <p class="text-[#6f7f55] font-bold tracking-[0.25em] text-sm mb-6">
                    JOURNAL
                </p>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight leading-tight">
                    暮らしを少し心地よくする読みもの
                </h1>

                <p class="mt-8 text-gray-600 text-base sm:text-lg leading-9">
                    商品の選び方、暮らしの整え方、お知らせなどをお届けします。
                    ShopSwiftでのお買い物がもっと楽しくなる情報をまとめました。
                </p>
            </div>

        </div>

        <div class="absolute right-[-120px] bottom-[-160px] w-[420px] h-[420px] rounded-full bg-white/50"></div>
    </section>

    <section class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 py-16 sm:py-20 lg:py-24">

        @if ($articles->count() > 0)

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                @foreach ($articles as $article)
                    <article class="group bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden hover:-translate-y-1 hover:shadow-md transition duration-300">

                        <a href="{{ route('articles.show', $article) }}" class="block">

                            <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">

                                @if ($article->thumbnail_path)
                                    <img src="{{ asset('storage/' . $article->thumbnail_path) }}"
                                         alt="{{ $article->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#eef1e7] to-[#dfe5d3] flex items-center justify-center">
                                        <i data-lucide="newspaper" class="w-16 h-16 text-[#6f7f55]"></i>
                                    </div>
                                @endif

                                <div class="absolute top-5 left-5">
                                    <span class="inline-flex rounded-full bg-white/90 px-4 py-2 text-xs font-bold text-[#6f7f55] shadow-sm">
                                        Journal
                                    </span>
                                </div>

                            </div>

                            <div class="p-7 sm:p-8">

                                <div class="flex items-center gap-2 text-gray-400 text-sm font-bold mb-5">
                                    <i data-lucide="calendar-days" class="w-4 h-4"></i>
                                    <span>
                                        {{ optional($article->published_at ?? $article->created_at)->format('Y.m.d') }}
                                    </span>
                                </div>

                                <h2 class="text-2xl font-bold leading-snug group-hover:text-[#6f7f55] transition">
                                    {{ $article->title }}
                                </h2>

                                <p class="mt-5 text-gray-600 leading-8 text-base">
                                    @if (!empty($article->excerpt))
                                        {{ $article->excerpt }}
                                    @else
                                        {{ Str::limit(strip_tags($article->body), 90) }}
                                    @endif
                                </p>

                                <div class="mt-8 inline-flex items-center gap-2 text-[#6f7f55] font-bold">
                                    続きを読む
                                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition"></i>
                                </div>

                            </div>

                        </a>

                    </article>
                @endforeach

            </div>

            @if (method_exists($articles, 'links'))
                <div class="mt-14">
                    {{ $articles->links() }}
                </div>
            @endif

        @else

            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm px-6 py-20 text-center">

                <div class="mx-auto w-20 h-20 rounded-full bg-[#eef1e7] flex items-center justify-center mb-8">
                    <i data-lucide="newspaper" class="w-10 h-10 text-[#6f7f55]"></i>
                </div>

                <h2 class="text-3xl font-bold">
                    記事はまだありません
                </h2>

                <p class="mt-5 text-gray-500 leading-8">
                    公開された記事がここに表示されます。
                </p>

                <a href="{{ route('products.index') }}"
                   class="mt-8 inline-flex items-center justify-center rounded-full bg-[#1f2933] text-white px-8 py-4 font-bold hover:bg-[#6f7f55] transition">
                    トップへ戻る
                </a>

            </div>

        @endif

    </section>

</main>

<footer class="bg-[#1f2933] text-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 py-12">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="text-2xl font-bold">ShopSwift</div>
                <p class="text-white/50 mt-3">暮らしに寄り添うオンラインストア</p>
            </div>

            <div class="flex flex-wrap gap-5 text-sm text-white/70 font-bold">
                <a href="{{ route('terms') }}" class="hover:text-white transition">利用規約</a>
                <a href="{{ route('privacy') }}" class="hover:text-white transition">プライバシーポリシー</a>
                <a href="{{ route('commercial') }}" class="hover:text-white transition">特定商取引法</a>
                <a href="{{ route('contact.index') }}" class="hover:text-white transition">お問い合わせ</a>
            </div>
        </div>
    </div>
</footer>

<script>
    lucide.createIcons();
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

</script>

</body>
</html>