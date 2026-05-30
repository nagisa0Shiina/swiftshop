<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="min-h-screen lg:flex">

    {{-- Sidebar --}}
    <aside class="hidden lg:flex lg:w-72 lg:shrink-0 min-h-screen bg-[#070d16] text-white flex-col">

        <div class="px-8 py-8 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="block">
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
               class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#070d16]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i>
                <span>ダッシュボード</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap transition
               {{ request()->routeIs('admin.products.*') ? 'bg-white text-[#070d16]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="package" class="w-5 h-5 shrink-0"></i>
                <span>商品管理</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap transition
               {{ request()->routeIs('admin.orders.*') ? 'bg-white text-[#070d16]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="clipboard-list" class="w-5 h-5 shrink-0"></i>
                <span>注文管理</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap transition text-white/80 hover:bg-white/10 hover:text-white">
                <i data-lucide="truck" class="w-5 h-5 shrink-0"></i>
                <span>発送状況</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap transition text-white/80 hover:bg-white/10 hover:text-white">
                <i data-lucide="credit-card" class="w-5 h-5 shrink-0"></i>
                <span>決済状況</span>
            </a>

            @if (Route::has('admin.articles.index'))
                <a href="{{ route('admin.articles.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap transition
                   {{ request()->routeIs('admin.articles.*') ? 'bg-white text-[#070d16]' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <i data-lucide="newspaper" class="w-5 h-5 shrink-0"></i>
                    <span>記事管理</span>
                </a>
            @endif

        </nav>

        <div class="px-4 py-6 border-t border-white/10 space-y-2">

            <a href="{{ route('products.index') }}"
               class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="external-link" class="w-5 h-5 shrink-0"></i>
                <span>サイトを見る</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="log-out" class="w-5 h-5 shrink-0"></i>
                    <span>ログアウト</span>
                </button>
            </form>

        </div>

    </aside>

    {{-- Mobile Header --}}
    <header class="lg:hidden sticky top-0 z-40 bg-[#070d16] text-white px-4 py-4 flex items-center justify-between">
        <div>
            <div class="text-xl font-bold">ShopSwift</div>
            <div class="text-xs tracking-widest text-white/50">ADMIN PANEL</div>
        </div>

        <a href="{{ route('products.index') }}"
           class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center">
            <i data-lucide="external-link" class="w-5 h-5"></i>
        </a>
    </header>

    {{-- Main --}}
    <main class="flex-1 min-w-0 px-4 sm:px-6 lg:px-10 py-8 lg:py-10">

        <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-6 mb-8">

            <div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight leading-tight">
                    ダッシュボード
                </h1>

                <p class="text-gray-500 mt-4 text-base sm:text-lg">
                    売上・注文状況を確認できます
                </p>
            </div>

            <a href="{{ route('products.index') }}"
               class="hidden lg:inline-flex items-center justify-center gap-3 bg-white border border-gray-200 rounded-3xl px-8 py-6 font-bold shadow-sm hover:bg-gray-50 shrink-0">
                <i data-lucide="external-link" class="w-5 h-5"></i>
                サイトを見る
            </a>

        </div>

        {{-- Stats --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">

            <div class="bg-white border border-gray-200 rounded-3xl p-7 shadow-sm min-w-0">
                <div class="flex items-start justify-between mb-8">
                    <div class="text-gray-500 font-bold">本日の売上</div>
                    <div class="w-7 h-7 rounded-full bg-green-100 shrink-0"></div>
                </div>

                <div class="text-4xl lg:text-5xl font-bold break-words">
                    ¥{{ number_format($todaySales ?? 0) }}
                </div>

                <div class="text-gray-400 mt-4 font-bold">
                    {{ now()->format('Y/m/d') }}
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-7 shadow-sm min-w-0">
                <div class="flex items-start justify-between mb-8">
                    <div class="text-gray-500 font-bold">総売上</div>
                    <i data-lucide="wallet-cards" class="w-7 h-7 text-blue-500 shrink-0"></i>
                </div>

                <div class="text-4xl lg:text-5xl font-bold break-words">
                    ¥{{ number_format($totalSales ?? 0) }}
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-7 shadow-sm min-w-0">
                <div class="flex items-start justify-between mb-8">
                    <div class="text-gray-500 font-bold">注文数</div>
                    <i data-lucide="shopping-bag" class="w-7 h-7 text-purple-500 shrink-0"></i>
                </div>

                <div class="text-4xl lg:text-5xl font-bold">
                    {{ number_format($ordersCount ?? 0) }}件
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-7 shadow-sm min-w-0">
                <div class="flex items-start justify-between mb-8">
                    <div class="text-gray-500 font-bold">商品数</div>
                    <i data-lucide="package" class="w-7 h-7 text-orange-500 shrink-0"></i>
                </div>

                <div class="text-4xl lg:text-5xl font-bold">
                    {{ number_format($productsCount ?? 0) }}件
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-7 shadow-sm min-w-0">
                <div class="flex items-start justify-between mb-8">
                    <div class="text-gray-500 font-bold">在庫切れ</div>
                    <i data-lucide="triangle-alert" class="w-7 h-7 text-red-500 shrink-0"></i>
                </div>

                <div class="text-4xl lg:text-5xl font-bold">
                    {{ number_format($outOfStockCount ?? 0) }}件
                </div>
            </div>

        </section>

        <section class="grid grid-cols-1 xl:grid-cols-3 gap-8">

            {{-- Recent Orders --}}
            <div class="xl:col-span-2 bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden min-w-0">

                <div class="px-6 py-6 border-b border-gray-200">
                    <h2 class="text-3xl font-bold">
                        最近の注文
                    </h2>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[780px] text-left">
                        <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-5 text-gray-500 font-bold">注文番号</th>
                            <th class="px-6 py-5 text-gray-500 font-bold">注文者</th>
                            <th class="px-6 py-5 text-gray-500 font-bold">金額</th>
                            <th class="px-6 py-5 text-gray-500 font-bold">状況</th>
                            <th class="px-6 py-5 text-gray-500 font-bold">日時</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse (($recentOrders ?? collect()) as $order)
                            <tr class="border-b border-gray-200 last:border-b-0">
                                <td class="px-6 py-8 font-bold">
                                    #{{ $order->id }}
                                </td>

                                <td class="px-6 py-8 font-bold">
                                    {{ $order->user->name ?? $order->name ?? '不明' }}
                                </td>

                                <td class="px-6 py-8 font-bold">
                                    ¥{{ number_format($order->total_amount ?? $order->total ?? 0) }}
                                </td>

                                <td class="px-6 py-8">
                                    <div class="flex flex-col items-start gap-2">
                                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold text-sm">
                                            {{ ($order->payment_status ?? '') === 'paid' ? '決済完了' : '未決済' }}
                                        </span>

                                        <span class="inline-flex px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-bold text-sm">
                                            {{ $order->shipping_status ?? $order->status ?? '発送準備中' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-8 text-gray-500 font-bold">
                                    {{ optional($order->created_at)->format('Y/m/d H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    注文はまだありません。
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>

            </div>

            {{-- Ranking --}}
            <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden min-w-0">

                <div class="px-6 py-6 border-b border-gray-200">
                    <h2 class="text-3xl font-bold">
                        人気商品ランキング
                    </h2>
                </div>

                <div class="p-6 space-y-5">

                    @forelse (($popularProducts ?? collect()) as $index => $product)
                        <div class="flex items-start justify-between gap-4">

                            <div>
                                <div class="text-gray-400 font-bold mb-2">
                                    {{ $index + 1 }}位
                                </div>

                                <div class="font-bold text-lg">
                                    {{ $product->name }}
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="font-bold">
                                    {{ $product->sold_count ?? $product->orders_count ?? 0 }}個
                                </div>

                                <div class="text-gray-500 text-sm">
                                    ¥{{ number_format($product->price ?? 0) }}
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="text-gray-500">
                            データはまだありません。
                        </div>
                    @endforelse

                </div>

            </div>

        </section>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>