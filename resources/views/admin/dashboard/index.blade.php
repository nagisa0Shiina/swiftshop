<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード | ShopSwift Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .admin-layout {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            background: #f5f6f7;
        }

        .admin-sidebar {
            width: 300px !important;
            min-width: 300px !important;
            max-width: 300px !important;
            flex: 0 0 300px !important;
            min-height: 100vh;
            background: #070d16;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        .admin-main {
            flex: 1;
            min-width: 0;
        }

        .admin-sidebar,
        .admin-sidebar *,
        .admin-sidebar a,
        .admin-sidebar span,
        .admin-sidebar button {
            writing-mode: horizontal-tb !important;
            text-orientation: mixed !important;
            white-space: nowrap !important;
            word-break: keep-all !important;
            overflow-wrap: normal !important;
            letter-spacing: normal !important;
        }

        .admin-sidebar-link,
        .admin-sidebar-button {
            width: 100% !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 16px !important;
            box-sizing: border-box !important;
        }

        .admin-sidebar-link svg,
        .admin-sidebar-button svg {
            width: 20px !important;
            height: 20px !important;
            min-width: 20px !important;
            flex-shrink: 0 !important;
        }

        @media (max-width: 1023px) {
            .admin-layout {
                display: block;
            }

            .admin-sidebar {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="admin-layout">

    {{-- PC Sidebar --}}
    <aside class="admin-sidebar hidden lg:flex">

        <div class="px-8 py-8 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="block text-white">
                <div class="text-2xl font-bold leading-none">
                    ShopSwift
                </div>
                <div class="mt-3 text-xs tracking-[0.25em] text-white/50">
                    ADMIN PANEL
                </div>
            </a>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold bg-white text-[#070d16] transition">
                <i data-lucide="layout-dashboard"></i>
                <span>ダッシュボード</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="package"></i>
                <span>商品管理</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="clipboard-list"></i>
                <span>注文管理</span>
            </a>

            <a href="{{ route('admin.shipping.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="truck"></i>
                <span>発送状況</span>
            </a>

            @if (Route::has('admin.payments.index'))
                <a href="{{ route('admin.payments.index') }}"
                   class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="credit-card"></i>
                    <span>決済状況</span>
                </a>
            @else
                <a href="{{ route('admin.orders.index') }}"
                   class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="credit-card"></i>
                    <span>決済状況</span>
                </a>
            @endif

            <a href="{{ route('admin.articles.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="newspaper"></i>
                <span>記事管理</span>
            </a>

        </nav>

        <div class="px-4 py-6 border-t border-white/10 space-y-2">

            <a href="{{ route('products.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="external-link"></i>
                <span>サイトを見る</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="admin-sidebar-button rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="log-out"></i>
                    <span>ログアウト</span>
                </button>
            </form>

        </div>

    </aside>

    {{-- Mobile Header --}}
    <header class="lg:hidden sticky top-0 z-50 bg-[#070d16] text-white px-5 py-5 flex items-center justify-between">
        <div>
            <div class="text-2xl font-bold leading-none">ShopSwift</div>
            <div class="mt-2 text-xs tracking-[0.25em] text-white/50">ADMIN PANEL</div>
        </div>

        <button type="button"
                id="adminMenuOpen"
                class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center">
            <i data-lucide="menu" class="w-7 h-7"></i>
        </button>
    </header>

    {{-- Mobile Drawer --}}
    <div id="adminMobileMenu"
         class="fixed inset-0 z-[999] hidden lg:hidden">

        <div id="adminMobileOverlay"
             class="absolute inset-0 bg-black/50"></div>

        <aside class="absolute left-0 top-0 h-full w-[82%] max-w-[320px] bg-[#070d16] text-white flex flex-col">

            <div class="px-6 py-7 border-b border-white/10 flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold leading-none">ShopSwift</div>
                    <div class="mt-2 text-xs tracking-[0.25em] text-white/50">ADMIN PANEL</div>
                </div>

                <button type="button"
                        id="adminMenuClose"
                        class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold bg-white text-[#070d16]">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>ダッシュボード</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span>商品管理</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
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

                <a href="{{ route('admin.articles.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                    <i data-lucide="newspaper" class="w-5 h-5"></i>
                    <span>記事管理</span>
                </a>

            </nav>

            <div class="px-4 py-6 border-t border-white/10 space-y-2">

                <a href="{{ route('products.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                    <i data-lucide="external-link" class="w-5 h-5"></i>
                    <span>サイトを見る</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span>ログアウト</span>
                    </button>
                </form>

            </div>

        </aside>
    </div>

    {{-- Main --}}
    <main class="admin-main px-4 sm:px-6 lg:px-10 py-8 lg:py-10">

        <div class="mb-8 lg:mb-10">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">

                <div>
                    <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">
                        ダッシュボード
                    </h1>

                    <p class="text-gray-500 mt-4 text-base sm:text-lg">
                        売上・注文状況を確認できます
                    </p>
                </div>

                <a href="{{ route('products.index') }}"
                   class="hidden lg:inline-flex items-center justify-center gap-3 rounded-3xl bg-white border border-gray-200 px-8 py-6 text-lg font-bold shadow-sm hover:bg-gray-50 transition">
                    <i data-lucide="external-link" class="w-5 h-5"></i>
                    サイトを見る
                </a>

            </div>
        </div>

        @php
            $todaySales = $todaySales ?? 0;
            $totalSales = $totalSales ?? 0;
            $ordersCount = $ordersCount ?? ($orders_count ?? 0);
            $productsCount = $productsCount ?? ($products_count ?? 0);
            $outOfStockCount = $outOfStockCount ?? ($out_of_stock_count ?? 0);

            $latestOrders = $latestOrders ?? $recentOrders ?? collect();
            $popularProducts = $popularProducts ?? collect();
        @endphp

        {{-- Stats --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8 lg:mb-10">

            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-7 min-h-[170px] relative overflow-hidden">
                <div class="absolute top-7 right-7 w-8 h-8 rounded-full bg-green-100"></div>

                <p class="text-gray-500 font-bold text-lg">
                    本日の売上
                </p>

                <div class="mt-8 text-5xl font-bold tracking-tight">
                    ¥{{ number_format($todaySales) }}
                </div>

                <p class="mt-4 text-gray-400 font-bold">
                    {{ now()->timezone('Asia/Tokyo')->format('Y/m/d') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-7 min-h-[170px] relative overflow-hidden">
                <i data-lucide="wallet-cards" class="absolute top-7 right-7 w-8 h-8 text-blue-500"></i>

                <p class="text-gray-500 font-bold text-lg">
                    総売上
                </p>

                <div class="mt-8 text-5xl font-bold tracking-tight">
                    ¥{{ number_format($totalSales) }}
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-7 min-h-[170px] relative overflow-hidden">
                <i data-lucide="shopping-bag" class="absolute top-7 right-7 w-8 h-8 text-purple-500"></i>

                <p class="text-gray-500 font-bold text-lg">
                    注文数
                </p>

                <div class="mt-8 text-5xl font-bold tracking-tight">
                    {{ number_format($ordersCount) }}件
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-7 min-h-[170px] relative overflow-hidden">
                <i data-lucide="package" class="absolute top-7 right-7 w-8 h-8 text-orange-500"></i>

                <p class="text-gray-500 font-bold text-lg">
                    商品数
                </p>

                <div class="mt-8 text-5xl font-bold tracking-tight">
                    {{ number_format($productsCount) }}件
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-7 min-h-[170px] relative overflow-hidden">
                <i data-lucide="triangle-alert" class="absolute top-7 right-7 w-8 h-8 text-red-500"></i>

                <p class="text-gray-500 font-bold text-lg">
                    在庫切れ
                </p>

                <div class="mt-8 text-5xl font-bold tracking-tight">
                    {{ number_format($outOfStockCount) }}件
                </div>
            </div>

        </section>

        <section class="grid grid-cols-1 xl:grid-cols-[1fr_420px] gap-6">

            {{-- Recent Orders --}}
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">

                <div class="px-6 py-6 border-b border-gray-200">
                    <h2 class="text-3xl font-bold">
                        最近の注文
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1060px] text-left">
                        <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">注文番号</th>
                            <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">注文者</th>
                            <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">商品名</th>
                            <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">金額</th>
                            <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">状況</th>
                            <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">日時</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($latestOrders as $order)

                            @php
                                $paymentStatus = $order->payment_status ?? '';
                                $shippingStatus = $order->shipping_status ?? $order->status ?? '';

                                $paymentLabel = match ($paymentStatus) {
                                    'paid' => '決済完了',
                                    'unpaid' => '未決済',
                                    'pending' => '決済待ち',
                                    'failed' => '決済失敗',
                                    'refunded' => '返金済み',
                                    default => $paymentStatus ?: '決済待ち',
                                };

                                $shippingLabel = match ($shippingStatus) {
                                    'pending' => '発送準備中',
                                    'preparing' => '発送準備中',
                                    'shipping' => '発送中',
                                    'shipped' => '発送中',
                                    'completed' => '配送完了',
                                    'delivered' => '配送完了',
                                    'cancelled' => 'キャンセル',
                                    default => $shippingStatus ?: '発送準備中',
                                };

                                $paymentClass = match ($paymentStatus) {
                                    'paid' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'unpaid' => 'bg-gray-100 text-gray-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                    'refunded' => 'bg-purple-100 text-purple-700',
                                    default => 'bg-yellow-100 text-yellow-700',
                                };

                                $shippingClass = match ($shippingStatus) {
                                    'preparing', 'pending' => 'bg-blue-100 text-blue-700',
                                    'shipping', 'shipped' => 'bg-orange-100 text-orange-700',
                                    'completed', 'delivered' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-blue-100 text-blue-700',
                                };
                            @endphp

                            <tr class="border-b border-gray-100 last:border-b-0">

                                <td class="px-6 py-7 font-bold whitespace-nowrap">
                                    #{{ $order->id }}
                                </td>

                                <td class="px-6 py-7 whitespace-nowrap">
                                    <div class="font-bold">
                                        {{ $order->user->name ?? $order->customer_name ?? $order->name ?? '不明' }}
                                    </div>

                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ $order->user->email ?? $order->customer_email ?? $order->email ?? '' }}
                                    </div>
                                </td>

                                <td class="px-6 py-7 min-w-[240px]">
                                    @if ($order->items && $order->items->count() > 0)
                                        <div class="space-y-2">
                                            @foreach ($order->items as $item)
                                                <div class="rounded-xl bg-gray-50 border border-gray-100 px-4 py-3">
                                                    <div class="font-bold text-sm text-gray-800 leading-6">
                                                        {{ $item->product_name ?? $item->product->name ?? '商品名なし' }}
                                                    </div>

                                                    <div class="mt-1 text-xs text-gray-500 font-bold">
                                                        数量：{{ $item->quantity }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 font-bold">
                                            商品情報なし
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-7 font-bold whitespace-nowrap">
                                    ¥{{ number_format($order->total_amount ?? $order->total ?? 0) }}
                                </td>

                                <td class="px-6 py-7">
                                    <div class="flex flex-col gap-2 items-start">
                                        <span class="inline-flex px-4 py-2 rounded-full {{ $paymentClass }} text-sm font-bold">
                                            {{ $paymentLabel }}
                                        </span>

                                        <span class="inline-flex px-4 py-2 rounded-full {{ $shippingClass }} text-sm font-bold">
                                            {{ $shippingLabel }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-7 text-gray-500 font-bold whitespace-nowrap">
                                    {{ optional($order->created_at)->timezone('Asia/Tokyo')->format('Y/m/d H:i') }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center text-gray-500 font-bold">
                                    注文はまだありません。
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>

            </div>

            {{-- Popular Products --}}
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">

                <div class="px-6 py-6 border-b border-gray-200">
                    <h2 class="text-3xl font-bold">
                        人気商品ランキング
                    </h2>
                </div>

                <div class="p-6 space-y-5">
                    @forelse ($popularProducts as $index => $product)
                        <div class="flex items-start justify-between gap-4 rounded-2xl border border-gray-100 bg-gray-50 px-5 py-4">

                            <div class="min-w-0">
                                <div class="text-gray-400 font-bold">
                                    {{ $index + 1 }}位
                                </div>

                                <div class="mt-2 font-bold text-lg leading-7 break-words">
                                    {{ $product->product_name ?? '商品名なし' }}
                                </div>
                            </div>

                            <div class="text-right font-bold shrink-0">

                                <div class="text-2xl">
                                    {{ number_format($product->total_quantity ?? 0) }}個
                                </div>

                                <div class="text-gray-400 text-sm mt-1">
                                    売上個数
                                </div>

                                <div class="text-gray-500 text-sm mt-3">
                                    売上 ¥{{ number_format($product->total_sales ?? 0) }}
                                </div>

                            </div>

                        </div>
                    @empty
                        <p class="text-gray-500 font-bold">
                            ランキングデータはまだありません。
                        </p>
                    @endforelse
                </div>

            </div>

        </section>

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