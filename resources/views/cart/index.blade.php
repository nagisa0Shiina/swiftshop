<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ショッピングカート | ShopSwift</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827]">

<div class="max-w-[1500px] mx-auto my-4 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

    <header class="h-20 px-8 flex items-center justify-between border-b border-gray-100">
        <a href="{{ route('products.index') }}" class="text-2xl font-bold">
            ShopSwift
        </a>

        <nav class="hidden md:flex items-center gap-12 text-sm font-medium">
            <a href="{{ route('products.index') }}">ホーム</a>
            <a href="{{ route('products.index') }}">商品一覧</a>
            <a href="{{ route('orders.index') }}">注文履歴</a>
            <a href="{{ route('cart.index') }}">マイページ</a>
        </nav>

        <div class="flex items-center gap-6">
            <i data-lucide="search" class="w-6 h-6"></i>

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
            ショッピングカート
        </h1>

        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-700 px-5 py-4 rounded-xl">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if ($cartItems->isEmpty())

            <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
                <p class="text-gray-500 mb-6">
                    カートは空です。
                </p>

                <a href="{{ route('products.index') }}"
                   class="inline-block bg-[#070d16] text-white px-8 py-4 rounded-md font-bold">
                    商品一覧へ戻る
                </a>
            </div>

        @else

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b text-sm text-gray-500">
                                <th class="text-left pb-4">商品</th>
                                <th class="text-right pb-4">価格</th>
                                <th class="text-center pb-4">数量</th>
                                <th class="text-right pb-4">小計</th>
                                <th class="pb-4"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($cartItems as $item)
                                @php
                                    $isUnavailable = ! $item->product->is_active || $item->product->stock <= 0;
                                @endphp

                                <tr class="border-b {{ $isUnavailable ? 'bg-red-50/40' : '' }}">
                                    <td class="py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
                                                @if ($item->product->image_path)
                                                    <img
                                                        src="{{ asset('storage/' . $item->product->image_path) }}"
                                                        class="w-full h-full object-cover {{ $isUnavailable ? 'opacity-40 grayscale' : '' }}"
                                                    >
                                                @else
                                                    <span class="text-2xl {{ $isUnavailable ? 'opacity-40 grayscale' : '' }}">
                                                        @if (str_contains($item->product->name, 'マグ') || str_contains($item->product->name, 'カップ'))
                                                            ☕
                                                        @elseif (str_contains($item->product->name, 'ディフューザー'))
                                                            🧴
                                                        @elseif (str_contains($item->product->name, 'バッグ'))
                                                            👜
                                                        @elseif (str_contains($item->product->name, 'ウォッチ') || str_contains($item->product->name, '時計'))
                                                            ⌚
                                                        @else
                                                            📦
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>

                                            <div>
                                                <div class="font-bold">
                                                    {{ $item->product->name }}
                                                </div>

                                                @if (! $item->product->is_active)
                                                    <div class="text-red-500 text-sm font-bold mt-1">
                                                        販売停止中の商品です
                                                    </div>
                                                @elseif ($item->product->stock <= 0)
                                                    <div class="text-red-500 text-sm font-bold mt-1">
                                                        売り切れの商品です
                                                    </div>
                                                @else
                                                    <div class="text-gray-500 text-sm mt-1">
                                                        在庫：{{ $item->product->stock }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-5 text-right text-sm">
                                        ¥{{ number_format($item->product->price) }}
                                    </td>

                                    <td class="py-5">
                                        <form
                                            method="POST"
                                            action="{{ route('cart.update', $item) }}"
                                            class="flex items-center justify-center gap-2"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input
                                                type="number"
                                                name="quantity"
                                                value="{{ $item->quantity }}"
                                                min="1"
                                                max="{{ max($item->product->stock, 1) }}"
                                                class="w-16 h-9 border rounded-md text-center text-sm {{ $isUnavailable ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}"
                                                @if ($isUnavailable)
                                                    disabled
                                                @endif
                                            >

                                            <button
                                                class="w-12 h-9 rounded-md text-xs
                                                    {{ $isUnavailable
                                                        ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                                        : 'bg-[#070d16] text-white hover:bg-gray-800'
                                                    }}"
                                                @if ($isUnavailable)
                                                    disabled
                                                @endif
                                            >
                                                更新
                                            </button>
                                        </form>
                                    </td>

                                    <td class="py-5 text-right font-bold text-sm">
                                        ¥{{ number_format($item->product->price * $item->quantity) }}
                                    </td>

                                    <td class="py-5 text-right">
                                        <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button class="text-gray-500 hover:text-red-500">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <aside class="bg-white border border-gray-200 rounded-xl p-6 h-fit">
                    <div class="space-y-4 border-b pb-5 mb-5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">小計</span>
                            <span class="font-bold">¥{{ number_format($total) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">送料</span>
                            <span class="font-bold">無料</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg font-bold">合計</span>
                        <span class="text-2xl font-bold">¥{{ number_format($total) }}</span>
                    </div>

                    @php
                $hasUnavailableItems = $cartItems->contains(function ($item) {
                    return ! $item->product->is_active || $item->product->stock <= 0;
                });
            @endphp

            @if ($hasUnavailableItems)

                <button
                    disabled
                    class="block w-full text-center bg-gray-300 text-gray-500 py-4 rounded-md font-bold cursor-not-allowed"
                >
                    購入できない商品が含まれています
                </button>

            @else

                <a href="{{ route('checkout.confirm') }}"
                class="block w-full text-center bg-[#070d16] text-white py-4 rounded-md font-bold hover:bg-gray-800 transition">
                    ご購入手続きへ
                </a>

            @endif

                    <a href="{{ route('products.index') }}"
                       class="block text-center mt-4 text-blue-500 text-sm">
                        ショッピングを続ける
                    </a>
                </aside>

            </div>

        @endif

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>