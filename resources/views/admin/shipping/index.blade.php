<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>発送状況 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .admin-layout {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
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
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
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

            <a href="{{ route('admin.orders.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold bg-white text-[#070d16] transition">
                <i data-lucide="truck"></i>
                <span>発送状況</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="credit-card"></i>
                <span>決済状況</span>
            </a>

            @if (Route::has('admin.articles.index'))
                <a href="{{ route('admin.articles.index') }}"
                   class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="newspaper"></i>
                    <span>記事管理</span>
                </a>
            @endif

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
    <header class="lg:hidden sticky top-0 z-40 bg-[#070d16] text-white px-4 py-4 flex items-center justify-between">
        <div>
            <div class="text-xl font-bold">ShopSwift</div>
            <div class="text-xs tracking-widest text-white/50">ADMIN PANEL</div>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
        </a>
    </header>

    {{-- Main --}}
    <main class="admin-main px-4 sm:px-6 lg:px-10 py-8 lg:py-10">

        <div class="mb-8">
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">
                発送状況
            </h1>

            <p class="text-gray-500 mt-4 text-base sm:text-lg">
                注文ごとの発送ステータスを確認できます
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <section class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">

            <div class="px-6 py-6 border-b border-gray-200 flex items-center justify-between gap-4">
                <h2 class="text-2xl sm:text-3xl font-bold">
                    発送一覧
                </h2>

                <div class="text-gray-400 font-bold whitespace-nowrap">
                    {{ isset($orders) ? $orders->count() : 0 }}件
                </div>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[980px] text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">注文番号</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">注文者</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">金額</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">発送状況</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">注文日時</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap text-right">操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($orders as $order)

                        @php
                            $shippingStatus = $order->shipping_status ?? $order->status ?? '';

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

                        <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition">

                            <td class="px-6 py-7 font-bold whitespace-nowrap">
                                #{{ $order->id }}
                            </td>

                            <td class="px-6 py-7 whitespace-nowrap">
                                <div class="font-bold">
                                    {{ $order->user->name ?? $order->name ?? '不明' }}
                                </div>

                                <div class="text-sm text-gray-500 mt-1">
                                    {{ $order->user->email ?? $order->email ?? '' }}
                                </div>
                            </td>

                            <td class="px-6 py-7 font-bold whitespace-nowrap">
                                ¥{{ number_format($order->total_amount ?? $order->total ?? 0) }}
                            </td>

                            <td class="px-6 py-7 whitespace-nowrap">
                                <span class="inline-flex px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-bold text-sm">
                                    {{ $shippingLabel }}
                                </span>
                            </td>

                            <td class="px-6 py-7 text-gray-500 font-bold whitespace-nowrap">
                                {{ optional($order->created_at)->format('Y/m/d H:i') }}
                            </td>

                            <td class="px-6 py-7">
                                <div class="flex items-center justify-end gap-3">

                                    @if (Route::has('admin.orders.edit'))
                                        <a href="{{ route('admin.orders.edit', $order) }}"
                                           class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 bg-white text-[#111827] font-bold hover:bg-gray-100 transition whitespace-nowrap">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                            編集
                                        </a>
                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <i data-lucide="truck" class="w-8 h-8 text-gray-400"></i>
                                </div>

                                <p class="text-gray-500 font-bold">
                                    発送対象の注文はまだありません。
                                </p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>

        </section>

        @if (isset($orders) && method_exists($orders, 'links'))
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>