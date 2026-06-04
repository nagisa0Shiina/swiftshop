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

<div class="w-full max-w-[1400px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

<x-site-header />

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

</script>

</body>
</html>