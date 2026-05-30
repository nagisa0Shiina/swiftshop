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

<div class="w-full max-w-[1500px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

    <header class="sticky top-0 z-40 bg-white h-16 sm:h-20 px-4 sm:px-6 lg:px-8 flex items-center justify-between border-b border-gray-100">

        <a href="{{ route('products.index') }}" class="text-xl sm:text-2xl font-bold">
            ShopSwift
        </a>

        <nav class="hidden lg:flex items-center gap-10 text-sm font-medium">
            <a href="{{ route('products.index') }}" class="hover:text-gray-500">
                ホーム
            </a>

            <a href="{{ route('products.all') }}" class="hover:text-gray-500">
                商品一覧
            </a>

            <a href="{{ route('orders.index') }}" class="hover:text-gray-500">
                注文履歴
            </a>

            <a href="{{ route('mypage') }}" class="hover:text-gray-500">
                マイページ
            </a>
        </nav>

        <div class="flex items-center gap-4 sm:gap-6">

            <a href="{{ route('cart.index') }}" class="relative">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>

                <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                </span>
            </a>

            <a href="{{ route('mypage') }}">
                <i data-lucide="user" class="w-6 h-6"></i>
            </a>

        </div>

    </header>

    <main class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6 sm:mb-8">

            <div>
                <h1 class="text-2xl sm:text-3xl font-bold">
                    ショッピングカート
                </h1>

                <p class="text-gray-500 text-sm mt-2">
                    カート内の商品を確認できます。
                </p>
            </div>

            <a href="{{ route('products.all') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 border border-gray-200 rounded-xl font-bold hover:bg-gray-50">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                買い物を続ける
            </a>

        </div>

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

            <div class="bg-white border border-gray-200 rounded-2xl p-8 sm:p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gray-100 flex items-center justify-center">
                    <i data-lucide="shopping-cart" class="w-8 h-8 text-gray-400"></i>
                </div>

                <p class="text-gray-500 mb-6">
                    カートは空です。
                </p>

                <a href="{{ route('products.all') }}"
                   class="inline-block bg-[#070d16] text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                    商品一覧へ戻る
                </a>
            </div>

        @else

            @php
                $hasUnavailableItems = $cartItems->contains(function ($item) {
                    return ! $item->product->is_active || $item->product->stock <= 0;
                });
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

                <div class="lg:col-span-2">

                    {{-- mobile cards --}}
                    <div class="lg:hidden space-y-5">

                        @foreach ($cartItems as $item)
                            @php
                                $isUnavailable = ! $item->product->is_active || $item->product->stock <= 0;
                            @endphp

                            <div class="border border-gray-200 rounded-2xl p-5 {{ $isUnavailable ? 'bg-red-50/40' : 'bg-white' }}">

                                <div class="flex gap-4">

                                    <div class="w-24 h-24 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0">
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

                                    <div class="min-w-0 flex-1">

                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <h2 class="font-bold text-xl break-words">
                                                    {{ $item->product->name }}
                                                </h2>

                                                <p class="text-gray-500 mt-2">
                                                    ¥{{ number_format($item->product->price) }}
                                                </p>
                                            </div>

                                            <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="w-12 h-12 rounded-full bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-500 flex items-center justify-center">
                                                    <i data-lucide="x" class="w-6 h-6"></i>
                                                </button>
                                            </form>
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
                                            <div class="text-gray-500 mt-2">
                                                在庫：{{ $item->product->stock }}
                                            </div>
                                        @endif

                                    </div>

                                </div>

                                <div class="border-t border-gray-100 mt-6 pt-6">

                                    <form method="POST"
                                          action="{{ route('cart.update', $item) }}"
                                          class="space-y-4">

                                        @csrf
                                        @method('PATCH')

                                        <div class="text-center text-gray-500 font-bold">
                                            数量
                                        </div>

                                        <div class="max-w-sm mx-auto border border-gray-200 rounded-2xl p-2 flex items-center justify-between bg-white">

                                            <button type="button"
                                                    class="quantity-minus w-14 h-14 rounded-xl border border-gray-200 flex items-center justify-center text-2xl font-bold hover:bg-gray-50 disabled:bg-gray-100 disabled:text-gray-400"
                                                    data-target="quantity-{{ $item->id }}"
                                                    @if ($isUnavailable) disabled @endif>
                                                −
                                            </button>

                                            <input
                                                id="quantity-{{ $item->id }}"
                                                type="number"
                                                name="quantity"
                                                value="{{ $item->quantity }}"
                                                min="1"
                                                max="{{ max($item->product->stock, 1) }}"
                                                class="w-24 h-14 text-center text-2xl font-bold border-0 focus:ring-0 focus:outline-none {{ $isUnavailable ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}"
                                                @if ($isUnavailable)
                                                    disabled
                                                @endif
                                            >

                                            <button type="button"
                                                    class="quantity-plus w-14 h-14 rounded-xl border border-gray-200 flex items-center justify-center text-3xl font-bold hover:bg-gray-50 disabled:bg-gray-100 disabled:text-gray-400"
                                                    data-target="quantity-{{ $item->id }}"
                                                    @if ($isUnavailable) disabled @endif>
                                                +
                                            </button>

                                        </div>

                                        <button type="submit"
                                                class="max-w-sm mx-auto w-full h-14 rounded-2xl text-base font-bold flex items-center justify-center gap-2
                                                    {{ $isUnavailable
                                                        ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                                        : 'bg-[#070d16] text-white hover:bg-gray-800'
                                                    }}"
                                                @if ($isUnavailable)
                                                    disabled
                                                @endif>
                                            <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                                            更新
                                        </button>

                                    </form>

                                </div>

                                <div class="mt-5 bg-gray-50 rounded-2xl px-5 py-4 text-right">
                                    <div class="text-gray-500 mb-1">
                                        小計
                                    </div>

                                    <div class="text-2xl font-bold">
                                        ¥{{ number_format($item->product->price * $item->quantity) }}
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>

                    {{-- desktop table --}}
                    <div class="hidden lg:block bg-white border border-gray-200 rounded-2xl overflow-hidden">

                        <div class="overflow-x-auto">

                            <table class="w-full min-w-[820px] border-collapse">
                                <thead>
                                    <tr class="border-b text-sm text-gray-500 bg-gray-50">
                                        <th class="text-left px-6 py-4">商品</th>
                                        <th class="text-right px-6 py-4">価格</th>
                                        <th class="text-center px-6 py-4">数量</th>
                                        <th class="text-right px-6 py-4">小計</th>
                                        <th class="px-6 py-4"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($cartItems as $item)
                                        @php
                                            $isUnavailable = ! $item->product->is_active || $item->product->stock <= 0;
                                        @endphp

                                        <tr class="border-b last:border-b-0 {{ $isUnavailable ? 'bg-red-50/40' : '' }}">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0">
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

                                            <td class="px-6 py-5 text-right text-sm whitespace-nowrap">
                                                ¥{{ number_format($item->product->price) }}
                                            </td>

                                            <td class="px-6 py-5">
                                                <form method="POST"
                                                      action="{{ route('cart.update', $item) }}"
                                                      class="flex items-center justify-center gap-2">
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

                                                    <button type="submit"
                                                            class="w-12 h-9 rounded-md text-xs
                                                                {{ $isUnavailable
                                                                    ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                                                    : 'bg-[#070d16] text-white hover:bg-gray-800'
                                                                }}"
                                                            @if ($isUnavailable)
                                                                disabled
                                                            @endif>
                                                        更新
                                                    </button>
                                                </form>
                                            </td>

                                            <td class="px-6 py-5 text-right font-bold text-sm whitespace-nowrap">
                                                ¥{{ number_format($item->product->price * $item->quantity) }}
                                            </td>

                                            <td class="px-6 py-5 text-right">
                                                <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="text-gray-500 hover:text-red-500">
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

                </div>

                <aside class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 h-fit lg:sticky lg:top-8">

                    <h2 class="text-2xl font-bold mb-5">
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

                        <button disabled
                                class="block w-full text-center bg-gray-300 text-gray-500 py-4 rounded-xl font-bold cursor-not-allowed">
                            購入できない商品が含まれています
                        </button>

                    @else

                        <a href="{{ route('checkout.confirm') }}"
                           class="block w-full text-center bg-[#070d16] text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                            ご購入手続きへ
                        </a>

                    @endif

                    <a href="{{ route('products.all') }}"
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

    document.querySelectorAll('.quantity-minus').forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.getElementById(button.dataset.target);

            if (!target) return;

            const min = Number(target.min || 1);
            const current = Number(target.value || min);

            if (current > min) {
                target.value = current - 1;
            }
        });
    });

    document.querySelectorAll('.quantity-plus').forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.getElementById(button.dataset.target);

            if (!target) return;

            const max = Number(target.max || 999);
            const current = Number(target.value || 1);

            if (current < max) {
                target.value = current + 1;
            }
        });
    });
</script>

</body>
</html>