<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショッピングカート | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="max-w-[1500px] mx-auto my-0 sm:my-4 bg-white border-x sm:border border-gray-200 sm:rounded-xl shadow-sm overflow-hidden min-h-screen">

    <header class="h-20 px-4 sm:px-8 flex items-center justify-between border-b border-gray-100 bg-white">
        <a href="{{ route('products.index') }}" class="text-2xl font-bold">
            ShopSwift
        </a>

        <nav class="hidden md:flex items-center gap-12 text-sm font-medium">
            <a href="{{ route('products.index') }}">ホーム</a>
            <a href="{{ route('products.all') }}">商品一覧</a>
            <a href="{{ route('orders.index') }}">注文履歴</a>
            <a href="{{ route('mypage') }}">マイページ</a>
        </nav>

        <div class="flex items-center gap-5 sm:gap-6">
            <a href="{{ route('cart.index') }}" class="relative">
                <i data-lucide="shopping-cart" class="w-7 h-7 sm:w-6 sm:h-6"></i>

                <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                </span>
            </a>

            <a href="{{ route('mypage') }}">
                <i data-lucide="user" class="w-7 h-7 sm:w-6 sm:h-6"></i>
            </a>
        </div>
    </header>

    <main class="px-4 sm:px-8 py-8">

        <h1 class="text-3xl sm:text-2xl font-bold mb-3">
            ショッピングカート
        </h1>

        <p class="text-gray-500 mb-8">
            カート内の商品を確認できます。
        </p>

        <a href="{{ route('products.index') }}"
           class="flex items-center justify-center gap-3 w-full border border-gray-200 rounded-2xl py-4 mb-8 font-bold text-lg hover:bg-gray-50">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
            買い物を続ける
        </a>

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

            <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center">
                <p class="text-gray-500 mb-6">
                    カートは空です。
                </p>

                <a href="{{ route('products.index') }}"
                   class="inline-block bg-[#070d16] text-white px-8 py-4 rounded-xl font-bold">
                    商品一覧へ戻る
                </a>
            </div>

        @else

            @php
                $hasUnavailableItems = $cartItems->contains(function ($item) {
                    return ! $item->product->is_active || $item->product->stock <= 0;
                });
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">

                    {{-- スマホ用カード表示 --}}
                    <div class="lg:hidden space-y-6">

                        @foreach ($cartItems as $item)
                            @php
                                $isUnavailable = ! $item->product->is_active || $item->product->stock <= 0;
                            @endphp

                            <div class="bg-white border border-gray-200 rounded-2xl p-5 {{ $isUnavailable ? 'bg-red-50/40' : '' }}">

                                <div class="flex gap-4">

                                    <div class="w-28 h-24 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0">
                                        @if ($item->product->image_path)
                                            <img
                                                src="{{ asset('storage/' . $item->product->image_path) }}"
                                                class="w-full h-full object-cover {{ $isUnavailable ? 'opacity-40 grayscale' : '' }}"
                                            >
                                        @else
                                            <span class="text-3xl {{ $isUnavailable ? 'opacity-40 grayscale' : '' }}">
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

                                    <div class="flex-1 min-w-0">

                                        <div class="flex items-start justify-between gap-3">

                                            <div>
                                                <div class="font-bold text-2xl leading-tight break-words">
                                                    {{ $item->product->name }}
                                                </div>

                                                <div class="text-gray-500 text-lg mt-2">
                                                    ¥{{ number_format($item->product->price) }}
                                                </div>

                                                @if (! $item->product->is_active)
                                                    <div class="text-red-500 text-sm font-bold mt-2">
                                                        販売停止中の商品です
                                                    </div>
                                                @elseif ($item->product->stock <= 0)
                                                    <div class="text-red-500 text-sm font-bold mt-2">
                                                        売り切れの商品です
                                                    </div>
                                                @else
                                                    <div class="text-gray-500 text-lg mt-2">
                                                        在庫：{{ $item->product->stock }}
                                                    </div>
                                                @endif
                                            </div>

                                            <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button class="w-12 h-12 rounded-full bg-gray-100 text-gray-500 hover:text-red-500 flex items-center justify-center">
                                                    <i data-lucide="x" class="w-6 h-6"></i>
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                </div>

                                <form
                                    method="POST"
                                    action="{{ route('cart.update', $item) }}"
                                    class="mt-6 flex flex-col items-center gap-3"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <div class="text-gray-500 font-bold">
                                        数量
                                    </div>

                                    <div class="flex items-center justify-center gap-3 w-full">

                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            max="{{ max($item->product->stock, 1) }}"
                                            class="w-28 h-12 border border-gray-300 rounded-full text-center text-xl font-bold {{ $isUnavailable ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}"
                                            @if ($isUnavailable)
                                                disabled
                                            @endif
                                        >

                                        <button
                                            class="h-12 px-8 rounded-full font-bold
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

                                    </div>
                                </form>

                                <div class="mt-6 bg-gray-50 rounded-2xl px-5 py-5 text-right">
                                    <div class="text-gray-500 mb-2">
                                        小計
                                    </div>

                                    <div class="text-2xl font-bold">
                                        ¥{{ number_format($item->product->price * $item->quantity) }}
                                    </div>
                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- PC用テーブル表示 --}}
                    <div class="hidden lg:block">
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
                                                            📦
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

                </div>

                <aside class="bg-white border border-gray-200 rounded-2xl p-6 h-fit">
                    <h2 class="text-3xl font-bold mb-6">
                        注文内容
                    </h2>

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
                        <span class="text-3xl font-bold">¥{{ number_format($total) }}</span>
                    </div>

                    @if ($hasUnavailableItems)

                        <button
                            disabled
                            class="block w-full text-center bg-gray-300 text-gray-500 py-4 rounded-xl font-bold cursor-not-allowed"
                        >
                            購入できない商品が含まれています
                        </button>

                    @else

                        <a href="{{ route('checkout.confirm') }}"
                           class="block w-full text-center bg-[#070d16] text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition">
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