<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>発送状況管理 | ShopSwift Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827]">

<div class="flex min-h-screen">

    {{-- sidebar --}}
    <aside class="w-64 shrink-0 bg-[#070d16] text-white">

        <div class="h-20 px-8 flex items-center border-b border-white/10">

            <div>
                <div class="text-2xl font-bold">
                    ShopSwift
                </div>

                <div class="text-xs text-gray-400">
                    ADMIN PANEL
                </div>
            </div>

        </div>

        <nav class="px-4 py-6 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">

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
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">

                <i data-lucide="truck" class="w-5 h-5"></i>

                発送状況

            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">

                <i data-lucide="credit-card" class="w-5 h-5"></i>

                決済状況

            </a>

        </nav>

    </aside>

    {{-- main --}}
    <main class="flex-1 min-w-0 p-8 overflow-hidden">

        <div class="mb-8">

            <h1 class="text-4xl font-bold mb-3">
                発送状況管理
            </h1>

            <p class="text-gray-500">
                配送ステータスを管理できます
            </p>

        </div>

        @if (session('success'))

            <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>

        @endif

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-[1200px] w-full">

                    <thead class="bg-gray-50 border-b">

                        <tr class="text-left text-sm text-gray-500">

                            <th class="px-6 py-4">
                                注文番号
                            </th>

                            <th class="px-6 py-4">
                                注文者
                            </th>

                            <th class="px-6 py-4">
                                配送先
                            </th>

                            <th class="px-6 py-4">
                                発送状況
                            </th>

                            <th class="px-6 py-4">
                                更新
                            </th>

                            <th class="px-6 py-4">
                                購入日時
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse ($orders as $order)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="px-6 py-3 font-bold whitespace-nowrap align-middle">
                                #{{ $order->id }}
                            </td>

                            <td class="px-6 py-3 min-w-[220px] align-middle">

                                <div class="font-bold">
                                    {{ $order->customer_name }}
                                </div>

                                <div class="text-sm text-gray-500 mt-1">
                                    {{ $order->customer_email }}
                                </div>

                            </td>

                            <td class="px-6 py-3 min-w-[260px] align-middle">

                                <div class="text-sm font-bold">
                                    〒{{ $order->postal_code }}
                                </div>

                                <div class="text-sm text-gray-600 mt-1 leading-relaxed">
                                    {{ $order->address }}
                                </div>

                            </td>

                            <td class="px-6 py-3 whitespace-nowrap align-middle">

                                @switch($order->shipping_status)

                                    @case('preparing')

                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
                                            発送準備中
                                        </span>

                                        @break

                                    @case('shipping')

                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                            発送中
                                        </span>

                                        @break

                                    @case('completed')

                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                            配送完了
                                        </span>

                                        @break

                                @endswitch

                            </td>

                            <td class="px-6 py-3 min-w-[220px] align-middle">

                                <form method="POST"
                                      action="{{ route('admin.orders.updateStatus', $order) }}"
                                      class="space-y-2">

                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="shipping_status"
                                        class="w-full border rounded-lg px-3 py-2 text-sm">

                                        <option value="preparing"
                                            @selected($order->shipping_status === 'preparing')>
                                            発送準備中
                                        </option>

                                        <option value="shipping"
                                            @selected($order->shipping_status === 'shipping')>
                                            発送中
                                        </option>

                                        <option value="completed"
                                            @selected($order->shipping_status === 'completed')>
                                            配送完了
                                        </option>

                                    </select>

                                    <button
                                        class="w-full bg-[#070d16] text-white py-2 rounded-lg text-sm hover:bg-gray-800">

                                        更新

                                    </button>

                                </form>

                            </td>

                            <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap align-middle">

                                {{ $order->created_at->format('Y/m/d H:i') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-16 text-center text-gray-500">

                                発送データがありません。

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>