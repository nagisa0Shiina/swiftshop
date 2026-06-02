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

   <header class="lg:hidden sticky top-0 z-40 bg-[#070d16] text-white border-b border-white/10">
        <div class="h-16 px-4 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-xl font-bold">ShopSwift</div>
                <div class="text-[10px] text-gray-400">ADMIN PANEL</div>
            </a>

            <button type="button" id="menuButton" class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <nav id="mobileMenu" class="hidden px-4 pb-4 space-y-2 bg-[#070d16]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>ダッシュボード
            </a>

            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="package" class="w-5 h-5"></i>商品管理
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>注文管理
            </a>

                    <a href="{{ route('admin.shipping.index') }}"
            class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="truck"></i>
                <span>発送状況</span>
</a>

            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="credit-card" class="w-5 h-5"></i>決済状況
            </a>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
                <i data-lucide="newspaper" class="w-5 h-5"></i>記事管理
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10">
                    <i data-lucide="log-out" class="w-5 h-5"></i>ログアウト
                </button>
            </form>
        </nav>
    </header>

    <aside class="hidden lg:flex lg:flex-col w-64 shrink-0 bg-[#070d16] text-white min-h-screen">

        <div class="h-20 px-8 flex items-center border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-2xl font-bold">ShopSwift</div>
                <div class="text-xs text-gray-400">ADMIN PANEL</div>
            </a>
        </div>

        <nav class="px-4 py-6 space-y-2 flex-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>ダッシュボード
            </a>

            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="package" class="w-5 h-5"></i>商品管理
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>注文管理
            </a>

            <a href="{{ route('admin.shipping.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="truck" class="w-5 h-5"></i>発送状況
            </a>

            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="credit-card" class="w-5 h-5"></i>決済状況
            </a>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
                <i data-lucide="newspaper" class="w-5 h-5"></i>記事管理
            </a>
        </nav>

        <div class="px-4 py-6 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10">
                    <i data-lucide="log-out" class="w-5 h-5"></i>ログアウト
                </button>
            </form>
        </div>

    </aside>


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

    const menuButton = document.getElementById('menuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            lucide.createIcons();
        });
    }
</script>

</body>
</html>