<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文管理 | ShopSwift Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="min-h-screen lg:flex">

    {{-- mobile header --}}
    <header class="lg:hidden sticky top-0 z-40 bg-[#070d16] text-white border-b border-white/10">
        <div class="h-16 px-4 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-xl font-bold">ShopSwift</div>
                <div class="text-[10px] text-gray-400">ADMIN PANEL</div>
            </a>

            <button type="button"
                    id="menuButton"
                    class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <nav id="mobileMenu" class="hidden px-4 pb-4 space-y-2 bg-[#070d16]">
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
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
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
                <div class="text-2xl font-bold">ShopSwift</div>
                <div class="text-xs text-gray-400">ADMIN PANEL</div>
            </a>
        </div>

        <nav class="px-4 py-6 space-y-2 flex-1">

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
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
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

        <div class="mb-8">

            <h1 class="text-3xl sm:text-4xl font-bold mb-3">
                注文管理
            </h1>

            <p class="text-gray-500 text-sm sm:text-base">
                注文内容・購入情報を確認できます
            </p>

        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- mobile order cards --}}
        <div class="lg:hidden space-y-4">

            @forelse ($orders as $order)

                <div class="bg-white border border-gray-200 rounded-2xl p-5">

                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <div class="text-sm text-gray-400 mb-1">
                                注文番号
                            </div>

                            <div class="text-xl font-bold">
                                #{{ $order->id }}
                            </div>
                        </div>

                        <form method="POST"
                              action="{{ route('admin.orders.destroy', $order) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('この注文を削除しますか？')"
                                    class="inline-flex items-center gap-1 px-3 py-2 bg-red-500 text-white rounded-lg text-xs hover:bg-red-600">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                削除
                            </button>
                        </form>
                    </div>

                    <div class="space-y-4 text-sm">

                        <div>
                            <div class="text-gray-400 font-bold mb-1">
                                注文者
                            </div>

                            <div class="font-bold">
                                {{ $order->customer_name }}
                            </div>

                            <div class="text-gray-500 mt-1 break-words">
                                {{ $order->customer_email }}
                            </div>

                            <div class="text-gray-500">
                                {{ $order->phone }}
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-400 font-bold mb-1">
                                配送先
                            </div>

                            <div class="font-bold">
                                〒{{ $order->postal_code }}
                            </div>

                            <div class="text-gray-600 mt-1 leading-relaxed">
                                {{ $order->address }}
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-400 font-bold mb-2">
                                商品内容
                            </div>

                            <div class="space-y-2">
                                @foreach ($order->items as $item)
                                    <div class="border rounded-xl px-3 py-2 bg-gray-50">
                                        <div class="font-bold">
                                            {{ $item->product_name }}
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            数量：{{ $item->quantity }} / ¥{{ number_format($item->price) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">

                            <div class="bg-gray-50 rounded-xl p-3">
                                <div class="text-gray-400 text-xs font-bold mb-1">
                                    合計金額
                                </div>

                                <div class="font-bold">
                                    ¥{{ number_format($order->total_amount) }}
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-3">
                                <div class="text-gray-400 text-xs font-bold mb-1">
                                    購入日時
                                </div>

                                <div class="font-bold text-xs">
                                    {{ $order->created_at->format('Y/m/d H:i') }}
                                </div>
                            </div>

                        </div>

                        <div>
                            <div class="text-gray-400 font-bold mb-2">
                                決済状況
                            </div>

                            @switch($order->payment_status)

                                @case('paid')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                        決済完了
                                    </span>
                                    @break

                                @case('pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
                                        未決済
                                    </span>
                                    @break

                                @case('refunded')
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">
                                        返金済み
                                    </span>
                                    @break

                            @endswitch
                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-white border border-gray-200 rounded-2xl px-6 py-16 text-center text-gray-500">
                    注文履歴がありません。
                </div>

            @endforelse

        </div>

        {{-- desktop table --}}
        <div class="hidden lg:block bg-white border border-gray-200 rounded-2xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-[1300px] w-full">

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
                                商品内容
                            </th>

                            <th class="px-6 py-4">
                                合計金額
                            </th>

                            <th class="px-6 py-4">
                                決済状況
                            </th>

                            <th class="px-6 py-4">
                                購入日時
                            </th>

                            <th class="px-6 py-4 text-right">
                                操作
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

                                <div class="text-sm text-gray-500">
                                    {{ $order->phone }}
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

                            <td class="px-6 py-3 min-w-[260px] align-middle">

                                <div class="space-y-2">

                                    @foreach ($order->items as $item)

                                        <div class="border rounded-lg px-3 py-1.5 bg-gray-50">

                                            <div class="font-bold text-sm">
                                                {{ $item->product_name }}
                                            </div>

                                            <div class="text-xs text-gray-500">
                                                数量：{{ $item->quantity }}
                                            </div>

                                            <div class="text-xs text-gray-500">
                                                ¥{{ number_format($item->price) }}
                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </td>

                            <td class="px-6 py-3 font-bold whitespace-nowrap align-middle">
                                ¥{{ number_format($order->total_amount) }}
                            </td>

                            <td class="px-6 py-3 whitespace-nowrap align-middle">

                                @switch($order->payment_status)

                                    @case('paid')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                            決済完了
                                        </span>
                                        @break

                                    @case('pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
                                            未決済
                                        </span>
                                        @break

                                    @case('refunded')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">
                                            返金済み
                                        </span>
                                        @break

                                @endswitch

                            </td>

                            <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap align-middle">
                                {{ $order->created_at->format('Y/m/d H:i') }}
                            </td>

                            <td class="px-6 py-3 text-right whitespace-nowrap align-middle">

                                <form method="POST"
                                      action="{{ route('admin.orders.destroy', $order) }}">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            onclick="return confirm('この注文を削除しますか？')"
                                            class="inline-flex items-center gap-1 px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        削除
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8"
                                class="px-6 py-16 text-center text-gray-500">
                                注文履歴がありません。
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-8 overflow-x-auto">
            {{ $orders->links() }}
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