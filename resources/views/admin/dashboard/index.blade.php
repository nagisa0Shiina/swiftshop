<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード | ShopSwift Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="min-h-screen lg:flex">

    {{-- mobile header --}}
    <header class="lg:hidden sticky top-0 z-40 bg-[#070d16] text-white border-b border-white/10">
        <div class="h-16 px-4 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-xl font-bold">
                    ShopSwift
                </div>
                <div class="text-[10px] text-gray-400">
                    ADMIN PANEL
                </div>
            </a>

            <button type="button"
                    id="menuButton"
                    class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <nav id="mobileMenu" class="hidden px-4 pb-4 space-y-2 bg-[#070d16]">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                ダッシュボード
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="package" class="w-5 h-5"></i>
                商品管理
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                注文管理
            </a>

            <a href="{{ route('admin.shipping.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="truck" class="w-5 h-5"></i>
                発送状況
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
                決済状況
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf

                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    ログアウト
                </button>
            </form>
        </nav>
    </header>

    {{-- desktop sidebar --}}
    <aside class="hidden lg:flex lg:flex-col w-64 shrink-0 bg-[#070d16] text-white min-h-screen">

        <div class="h-20 px-8 flex items-center border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-2xl font-bold">
                    ShopSwift
                </div>

                <div class="text-xs text-gray-400">
                    ADMIN PANEL
                </div>
            </a>
        </div>

        <nav class="px-4 py-6 space-y-2 flex-1">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                ダッシュボード
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="package" class="w-5 h-5"></i>
                商品管理
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                注文管理
            </a>

            <a href="{{ route('admin.shipping.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="truck" class="w-5 h-5"></i>
                発送状況
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
                決済状況
            </a>

        </nav>

        <div class="px-4 py-6 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    ログアウト
                </button>
            </form>
        </div>

    </aside>

    {{-- main --}}
    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8">

        <div class="mb-8 lg:mb-10">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

                <div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 lg:mb-4">
                        ダッシュボード
                    </h1>

                    <p class="text-gray-500 text-base sm:text-lg lg:text-xl">
                        売上・注文状況を確認できます
                    </p>
                </div>

                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-white border border-gray-200 rounded-2xl font-bold hover:bg-gray-50">
                    <i data-lucide="external-link" class="w-5 h-5"></i>
                    サイトを見る
                </a>

            </div>

        </div>

        {{-- cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 sm:gap-6 mb-8 lg:mb-10">

            <div class="bg-white border border-gray-200 rounded-3xl p-5 sm:p-6 lg:p-8">

                <div class="flex items-center justify-between mb-5 lg:mb-6">
                    <h2 class="text-gray-500 font-bold">
                        本日の売上
                    </h2>

                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-green-100 flex items-center justify-center">
                        <i data-lucide="yen-sign" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>

                <div class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 lg:mb-4 break-words">
                    ¥{{ number_format($todaySales) }}
                </div>

                <div class="text-gray-400 text-sm">
                    {{ now()->format('Y/m/d') }}
                </div>

            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-5 sm:p-6 lg:p-8">

                <div class="flex items-center justify-between mb-5 lg:mb-6">
                    <h2 class="text-gray-500 font-bold">
                        総売上
                    </h2>

                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                        <i data-lucide="wallet" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>

                <div class="text-3xl sm:text-4xl lg:text-5xl font-bold break-words">
                    ¥{{ number_format($totalSales) }}
                </div>

            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-5 sm:p-6 lg:p-8">

                <div class="flex items-center justify-between mb-5 lg:mb-6">
                    <h2 class="text-gray-500 font-bold">
                        注文数
                    </h2>

                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-purple-100 flex items-center justify-center">
                        <i data-lucide="shopping-bag" class="w-6 h-6 text-purple-600"></i>
                    </div>
                </div>

                <div class="text-3xl sm:text-4xl lg:text-5xl font-bold">
                    {{ $ordersCount }}件
                </div>

            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-5 sm:p-6 lg:p-8">

                <div class="flex items-center justify-between mb-5 lg:mb-6">
                    <h2 class="text-gray-500 font-bold">
                        商品数
                    </h2>

                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-orange-100 flex items-center justify-center">
                        <i data-lucide="package" class="w-6 h-6 text-orange-600"></i>
                    </div>
                </div>

                <div class="text-3xl sm:text-4xl lg:text-5xl font-bold">
                    {{ $productsCount }}件
                </div>

            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-5 sm:p-6 lg:p-8">

                <div class="flex items-center justify-between mb-5 lg:mb-6">
                    <h2 class="text-gray-500 font-bold">
                        在庫切れ
                    </h2>

                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-red-100 flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                    </div>
                </div>

                <div class="text-3xl sm:text-4xl lg:text-5xl font-bold">
                    {{ $outOfStockCount }}件
                </div>

            </div>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">

            {{-- 最近の注文 --}}
            <div class="xl:col-span-2 bg-white border border-gray-200 rounded-3xl overflow-hidden">

                <div class="px-5 sm:px-8 py-5 sm:py-6 border-b">
                    <h2 class="text-2xl sm:text-3xl font-bold">
                        最近の注文
                    </h2>
                </div>

                {{-- mobile --}}
                <div class="lg:hidden divide-y divide-gray-200">

                    @forelse ($recentOrders as $order)

                        <div class="p-5">

                            <div class="flex items-center justify-between gap-4 mb-4">

                                <div class="min-w-0">
                                    <div class="text-sm text-gray-400 mb-1">
                                        注文番号
                                    </div>

                                    <div class="text-2xl font-bold">
                                        #{{ $order->id }}
                                    </div>
                                </div>

                                <div class="flex flex-col items-end gap-2 shrink-0 min-w-[116px]">

                                    @switch($order->payment_status)

                                        @case('paid')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold min-w-[88px]">
                                                決済完了
                                            </span>
                                            @break

                                        @case('pending')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold min-w-[72px]">
                                                未決済
                                            </span>
                                            @break

                                        @case('refunded')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-red-100 text-red-700 rounded-full text-sm font-bold min-w-[88px]">
                                                返金済み
                                            </span>
                                            @break

                                    @endswitch

                                    @switch($order->shipping_status)

                                        @case('preparing')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold min-w-[104px]">
                                                発送準備中
                                            </span>
                                            @break

                                        @case('shipping')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-bold min-w-[72px]">
                                                発送中
                                            </span>
                                            @break

                                        @case('completed')
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold min-w-[88px]">
                                                配送完了
                                            </span>
                                            @break

                                    @endswitch

                                </div>

                            </div>

                            <div class="grid grid-cols-2 gap-3 text-sm">

                                <div class="bg-gray-50 rounded-2xl p-4">
                                    <div class="text-gray-400 font-bold mb-1">
                                        注文者
                                    </div>

                                    <div class="font-bold break-words">
                                        {{ $order->customer_name }}
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-4">
                                    <div class="text-gray-400 font-bold mb-1">
                                        金額
                                    </div>

                                    <div class="font-bold">
                                        ¥{{ number_format($order->total_amount) }}
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-4 col-span-2">
                                    <div class="text-gray-400 font-bold mb-1">
                                        日時
                                    </div>

                                    <div class="font-bold">
                                        {{ $order->created_at->format('Y/m/d H:i') }}
                                    </div>
                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="px-6 py-16 text-center text-gray-500">
                            注文データがありません。
                        </div>

                    @endforelse

                </div>

                {{-- desktop --}}
                <div class="hidden lg:block overflow-x-auto">

                    <table class="w-full min-w-[820px]">

                        <thead class="bg-gray-50 border-b">

                            <tr class="text-left text-sm text-gray-500">

                                <th class="px-6 py-4">
                                    注文番号
                                </th>

                                <th class="px-6 py-4">
                                    注文者
                                </th>

                                <th class="px-6 py-4">
                                    金額
                                </th>

                                <th class="px-6 py-4">
                                    状況
                                </th>

                                <th class="px-6 py-4">
                                    日時
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                        @forelse ($recentOrders as $order)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-6 py-5 font-bold whitespace-nowrap">
                                    #{{ $order->id }}
                                </td>

                                <td class="px-6 py-5 whitespace-nowrap">
                                    {{ $order->customer_name }}
                                </td>

                                <td class="px-6 py-5 font-bold whitespace-nowrap">
                                    ¥{{ number_format($order->total_amount) }}
                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex flex-col items-start gap-2 shrink-0 min-w-[116px]">

                                        @switch($order->payment_status)

                                            @case('paid')
                                                <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold min-w-[88px]">
                                                    決済完了
                                                </span>
                                                @break

                                            @case('pending')
                                                <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold min-w-[72px]">
                                                    未決済
                                                </span>
                                                @break

                                            @case('refunded')
                                                <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-red-100 text-red-700 rounded-full text-sm font-bold min-w-[88px]">
                                                    返金済み
                                                </span>
                                                @break

                                        @endswitch

                                        @switch($order->shipping_status)

                                            @case('preparing')
                                                <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold min-w-[104px]">
                                                    発送準備中
                                                </span>
                                                @break

                                            @case('shipping')
                                                <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-bold min-w-[72px]">
                                                    発送中
                                                </span>
                                                @break

                                            @case('completed')
                                                <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold min-w-[88px]">
                                                    配送完了
                                                </span>
                                                @break

                                        @endswitch

                                    </div>

                                </td>

                                <td class="px-6 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $order->created_at->format('Y/m/d H:i') }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="px-6 py-16 text-center text-gray-500">
                                    注文データがありません。
                                </td>
                            </tr>

                        @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

            {{-- 人気商品 --}}
            <div class="bg-white border border-gray-200 rounded-3xl overflow-hidden">

                <div class="px-5 sm:px-8 py-5 sm:py-6 border-b">
                    <h2 class="text-2xl sm:text-3xl font-bold">
                        人気商品ランキング
                    </h2>
                </div>

                <div class="divide-y">

                    @forelse ($popularProducts as $index => $product)

                        <div class="p-5 sm:p-6 flex items-center justify-between gap-4">

                            <div class="min-w-0">

                                <div class="text-sm text-gray-400 mb-1">
                                    {{ $index + 1 }}位
                                </div>

                                <div class="font-bold text-base sm:text-lg break-words">
                                    {{ $product->product_name }}
                                </div>

                            </div>

                            <div class="text-right shrink-0">

                                <div class="font-bold">
                                    {{ $product->total_quantity }}個
                                </div>

                                <div class="text-sm text-gray-500">
                                    ¥{{ number_format($product->total_sales) }}
                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="p-8 text-center text-gray-500">
                            商品データがありません。
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

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