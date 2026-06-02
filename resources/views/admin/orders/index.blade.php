<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文管理 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .admin-sidebar,
        .admin-sidebar *,
        .admin-sidebar a,
        .admin-sidebar span,
        .admin-sidebar button {
            writing-mode: horizontal-tb !important;
            text-orientation: mixed !important;
            word-break: keep-all !important;
            overflow-wrap: normal !important;
            white-space: nowrap !important;
        }

        .admin-sidebar a,
        .admin-sidebar button {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-start !important;
            width: 100% !important;
        }

        .admin-sidebar svg {
            flex-shrink: 0 !important;
        }
    </style>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="min-h-screen lg:flex">

    <aside class="admin-sidebar hidden lg:flex w-[300px] shrink-0 min-h-screen flex-col bg-[#070d16] text-white">

        <div class="px-8 py-8 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="block">
                <div class="text-2xl font-bold leading-none whitespace-nowrap">
                    ShopSwift
                </div>
                <div class="mt-3 text-xs tracking-[0.25em] text-white/50 whitespace-nowrap">
                    ADMIN PANEL
                </div>
            </a>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
               class="gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>ダッシュボード</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="package" class="w-5 h-5"></i>
                <span>商品管理</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="gap-4 rounded-2xl px-5 py-4 text-base font-bold bg-white text-[#070d16] transition">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span>注文管理</span>
            </a>

            <a href="{{ route('admin.shipping.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                    <i data-lucide="truck" class="w-5 h-5"></i>
                    <span>発送状況</span>
                </a>

                @if (Route::has('admin.payments.index'))
                    <a href="{{ route('admin.payments.index') }}"
                       class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                        <span>決済状況</span>
                    </a>
                @else
                    <a href="{{ route('admin.orders.index') }}"
                       class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                        <span>決済状況</span>
                    </a>
                @endif  

            @if (Route::has('admin.articles.index'))
                <a href="{{ route('admin.articles.index') }}"
                   class="gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="newspaper" class="w-5 h-5"></i>
                    <span>記事管理</span>
                </a>
            @endif

        </nav>

        <div class="px-4 py-6 border-t border-white/10 space-y-2">

            <a href="{{ route('products.index') }}"
               class="gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="external-link" class="w-5 h-5"></i>
                <span>サイトを見る</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span>ログアウト</span>
                </button>
            </form>

        </div>


    <main class="flex-1 min-w-0 px-4 sm:px-6 lg:px-10 py-8 lg:py-10">

        <div class="mb-8">
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">
                注文管理
            </h1>

            <p class="text-gray-500 mt-4 text-base sm:text-lg">
                注文内容・発送状況・決済状況を確認できます
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <section class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1100px] text-left">

                    <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">注文番号</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">注文者</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">金額</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">決済状況</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">発送状況</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">注文日時</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($orders as $order)

                        @php
                            $paymentStatus = $order->payment_status ?? $order->status ?? '';
                            $shippingStatus = $order->shipping_status ?? '';

                            $paymentLabel = match ($paymentStatus) {
                                'paid' => '決済完了',
                                'unpaid' => '未決済',
                                'pending' => '決済待ち',
                                'failed' => '決済失敗',
                                'refunded' => '返金済み',
                                default => $paymentStatus ? $paymentStatus : '未決済',
                            };

                            $shippingLabel = match ($shippingStatus) {
                                'pending' => '発送準備中',
                                'preparing' => '発送準備中',
                                'shipping' => '発送中',
                                'shipped' => '発送済み',
                                'completed' => '配送完了',
                                'delivered' => '配送完了',
                                'cancelled' => 'キャンセル',
                                default => $shippingStatus ? $shippingStatus : '発送準備中',
                            };
                        @endphp

                        <tr class="border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition">

                            <td class="px-6 py-7 font-bold whitespace-nowrap">
                                #{{ $order->id }}
                            </td>

                            <td class="px-6 py-7 font-bold whitespace-nowrap">
                                {{ $order->user->name ?? $order->name ?? '不明' }}
                            </td>

                            <td class="px-6 py-7 font-bold whitespace-nowrap">
                                ¥{{ number_format($order->total_amount ?? $order->total ?? 0) }}
                            </td>

                            <td class="px-6 py-7 whitespace-nowrap">
                                <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold text-sm">
                                    {{ $paymentLabel }}
                                </span>
                            </td>

                            <td class="px-6 py-7 whitespace-nowrap">
                                <span class="inline-flex px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-bold text-sm">
                                    {{ $shippingLabel }}
                                </span>
                            </td>

                            <td class="px-6 py-7 text-gray-500 font-bold whitespace-nowrap">
                                {{ optional($order->created_at)->format('Y/m/d H:i') }}
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500 font-bold">
                                注文はまだありません。
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>

        </section>

        @if (method_exists($orders, 'links'))
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif

    </main>

</div>

<script>
    lucide.createIcons();

    const adminMenuOpen = document.getElementById('adminMenuOpen');
    const adminMenuClose = document.getElementById('adminMenuClose');
    const adminMobileMenu = document.getElementById('adminMobileMenu');
    const adminMobileOverlay = document.getElementById('adminMobileOverlay');

    if (adminMenuOpen && adminMobileMenu) {
        adminMenuOpen.addEventListener('click', () => {
            adminMobileMenu.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    }

    function closeAdminMenu() {
        if (!adminMobileMenu) return;
        adminMobileMenu.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    if (adminMenuClose) {
        adminMenuClose.addEventListener('click', closeAdminMenu);
    }

    if (adminMobileOverlay) {
        adminMobileOverlay.addEventListener('click', closeAdminMenu);
    }
</script>

</body>
</html>