<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文履歴 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="w-full max-w-[1500px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

<x-site-header />
    <main class="w-full max-w-full px-4 sm:px-8 py-8 overflow-x-hidden">

        <div class="mb-8">

            <h1 class="text-3xl sm:text-4xl font-bold mb-3">
                注文履歴
            </h1>

            <p class="text-gray-500">
                これまでの注文内容を確認できます。
            </p>

        </div>

        <a href="{{ route('products.index') }}"
           class="flex items-center justify-center gap-3 w-full border border-gray-200 rounded-2xl py-4 mb-8 font-bold text-lg hover:bg-gray-50">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
            買い物を続ける
        </a>

        @if ($orders->isEmpty())

            <div class="bg-white border border-gray-200 rounded-2xl p-10 sm:p-12 text-center">

                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gray-100 flex items-center justify-center">
                    <i data-lucide="receipt" class="w-8 h-8 text-gray-400"></i>
                </div>

                <p class="text-gray-500 mb-6">
                    注文履歴はまだありません。
                </p>

                <a href="{{ route('products.index') }}"
                   class="inline-block bg-[#070d16] text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                    商品を探す
                </a>

            </div>

        @else

            <div class="space-y-6">

                @foreach ($orders as $order)

                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">

                        <div class="bg-gray-50 px-5 sm:px-6 py-5 border-b border-gray-100">

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                                <div>
                                    <div class="text-sm text-gray-400 font-bold mb-1">
                                        注文番号
                                    </div>

                                    <div class="text-2xl font-bold">
                                        #{{ $order->id }}
                                    </div>

                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ $order->created_at->format('Y/m/d H:i') }}
                                    </div>
                                </div>

                                <div class="flex flex-col sm:items-end gap-3">

                                    <div class="flex flex-wrap gap-2">

                                        @if ($order->status === 'paid')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold min-w-[88px]">
                                                決済済み
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold min-w-[88px]">
                                                決済待ち
                                            </span>
                                        @endif

                                        @if ($order->shipping_status === 'preparing')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold min-w-[104px]">
                                                発送準備中
                                            </span>
                                        @elseif ($order->shipping_status === 'shipping')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-bold min-w-[72px]">
                                                発送中
                                            </span>
                                        @elseif ($order->shipping_status === 'completed')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold min-w-[88px]">
                                                配送完了
                                            </span>
                                        @endif

                                    </div>

                                    <div class="text-2xl sm:text-3xl font-bold">
                                        ¥{{ number_format($order->total_amount) }}
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="p-5 sm:p-6">

                            <h2 class="text-xl font-bold mb-5">
                                注文商品
                            </h2>

                            <div class="space-y-4">

                                @foreach ($order->items as $item)

                                    <div class="flex items-start justify-between gap-4 border-b last:border-b-0 pb-4 last:pb-0">

                                        <div class="min-w-0">

                                            <div class="font-bold text-base sm:text-lg break-words">
                                                {{ $item->product_name }}
                                            </div>

                                            <div class="text-sm text-gray-500 mt-1">
                                                ¥{{ number_format($item->price) }} × {{ $item->quantity }}
                                            </div>

                                        </div>

                                        <div class="font-bold text-right whitespace-nowrap">
                                            ¥{{ number_format($item->price * $item->quantity) }}
                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="mt-8 overflow-x-auto">
                {{ $orders->links() }}
            </div>

        @endif

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