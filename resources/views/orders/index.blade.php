<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文履歴 | ShopSwift</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827]">

<div class="max-w-[1500px] mx-auto my-4 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

    <header class="h-20 px-8 flex items-center justify-between border-b border-gray-100">
        <a href="{{ route('products.index') }}" class="text-2xl font-bold">ShopSwift</a>

        <nav class="hidden md:flex items-center gap-12 text-sm font-medium">
            <a href="{{ route('products.index') }}">ホーム</a>
            <a href="{{ route('products.index') }}">商品一覧</a>
            <a href="{{ route('cart.index') }}">カート</a>
            <a href="{{ route('orders.index') }}" class="font-bold">注文履歴</a>
        </nav>

        <div class="flex items-center gap-6">
            <a href="{{ route('cart.index') }}" class="relative">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                </span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button>
                    <i data-lucide="user" class="w-6 h-6"></i>
                </button>
            </form>
        </div>
    </header>

    <main class="px-8 py-8">

        <h1 class="text-2xl font-bold mb-8">
            注文履歴
        </h1>

        @if ($orders->isEmpty())

            <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
                <p class="text-gray-500 mb-6">
                    注文履歴はまだありません。
                </p>

                <a href="{{ route('products.index') }}"
                   class="inline-block bg-[#070d16] text-white px-8 py-4 rounded-md font-bold">
                    商品を探す
                </a>
            </div>

        @else

            <div class="space-y-6">

                @foreach ($orders as $order)
                    <div class="border border-gray-200 rounded-xl overflow-hidden">

                        <div class="bg-gray-50 px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <div class="font-bold">
                                    注文番号 #{{ $order->id }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $order->created_at->format('Y/m/d H:i') }}
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    {{ $order->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $order->status === 'paid' ? '決済済み' : '決済待ち' }}
                                </span>

                                <span class="font-bold text-lg">
                                    ¥{{ number_format($order->total_amount) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            @foreach ($order->items as $item)
                                <div class="flex items-center justify-between border-b last:border-b-0 pb-4 last:pb-0">
                                    <div>
                                        <div class="font-bold">
                                            {{ $item->product_name }}
                                        </div>

                                        <div class="text-sm text-gray-500">
                                            ¥{{ number_format($item->price) }} × {{ $item->quantity }}
                                        </div>
                                    </div>

                                    <div class="font-bold">
                                        ¥{{ number_format($item->price * $item->quantity) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach

            </div>

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