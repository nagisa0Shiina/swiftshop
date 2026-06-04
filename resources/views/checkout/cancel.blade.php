<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>決済キャンセル | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="w-full max-w-[1200px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">
<x-site-header />
    <main class="px-4 sm:px-8 py-10 sm:py-16">

        <div class="max-w-2xl mx-auto">

            <div class="bg-white border border-gray-200 rounded-3xl p-6 sm:p-10 text-center">

                <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-8 rounded-3xl bg-yellow-100 flex items-center justify-center">
                    <i data-lucide="circle-alert" class="w-10 h-10 sm:w-12 sm:h-12 text-yellow-700"></i>
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    決済をキャンセルしました
                </h1>

                <p class="text-gray-500 leading-relaxed mb-8">
                    お支払いは完了していません。<br class="hidden sm:block">
                    カート内の商品はそのまま残っています。
                </p>

                <div class="bg-gray-50 rounded-2xl p-5 sm:p-6 mb-8 text-left">

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-gray-500"></i>
                        </div>

                        <div>
                            <div class="font-bold mb-1">
                                もう一度購入手続きできます
                            </div>

                            <p class="text-sm text-gray-500 leading-relaxed">
                                カートへ戻ると、配送先情報を確認して再度お支払いへ進めます。
                            </p>
                        </div>
                    </div>

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    <a href="{{ route('cart.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white px-6 py-4 rounded-2xl font-bold hover:bg-gray-800 transition">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                        カートへ戻る
                    </a>

                    <a href="{{ route('products.all') }}"
                       class="inline-flex items-center justify-center gap-2 border border-gray-200 px-6 py-4 rounded-2xl font-bold hover:bg-gray-50 transition">
                        <i data-lucide="package" class="w-5 h-5"></i>
                        商品一覧を見る
                    </a>

                </div>

            </div>

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