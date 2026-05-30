<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入確認 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="w-full max-w-[1400px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

    {{-- header --}}
    <header class="sticky top-0 z-40 bg-white h-16 sm:h-20 px-4 sm:px-8 flex items-center justify-between border-b border-gray-100">

        <a href="{{ route('products.index') }}"
           class="text-xl sm:text-2xl font-bold">
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

        <div class="flex items-center gap-5 sm:gap-6">

            <a href="{{ route('cart.index') }}"
               class="relative">

                <i data-lucide="shopping-cart"
                   class="w-7 h-7 sm:w-6 sm:h-6"></i>

                <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                </span>

            </a>

            <a href="{{ route('mypage') }}">
                <i data-lucide="user" class="w-7 h-7 sm:w-6 sm:h-6"></i>
            </a>

        </div>

    </header>

    {{-- main --}}
    <main class="w-full max-w-full px-4 sm:px-8 py-8 overflow-x-hidden">

        <div class="mb-8">

            <h1 class="text-3xl sm:text-4xl font-bold mb-3">
                購入確認
            </h1>

            <p class="text-gray-500">
                注文内容と配送先情報を確認してください。
            </p>

        </div>

        <a href="{{ route('cart.index') }}"
           class="flex items-center justify-center gap-3 w-full border border-gray-200 rounded-2xl py-4 mb-8 font-bold text-lg hover:bg-gray-50">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
            カートへ戻る
        </a>

        <form method="POST"
              action="{{ route('checkout.store') }}">

            @csrf

            @if ($errors->any())

                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-xl">

                    <div class="font-bold mb-2">
                        入力内容を確認してください
                    </div>

                    <ul class="list-disc list-inside space-y-1 text-sm">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- left --}}
                <div class="space-y-5 sm:space-y-6">

                    <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6">

                        <h2 class="text-2xl font-bold mb-5">
                            注文商品
                        </h2>

                        <div class="space-y-4">

                            @foreach ($cartItems as $cartItem)

                                <div class="border border-gray-200 rounded-2xl p-4 flex gap-4">

                                    <div
                                        class="bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0"
                                        style="width:96px; height:96px; min-width:96px; max-width:96px;"
                                    >

                                        @if ($cartItem->product->image_path)

                                            <img
                                                src="{{ asset('storage/' . $cartItem->product->image_path) }}"
                                                alt="{{ $cartItem->product->name }}"
                                                style="width:96px; height:96px; min-width:96px; max-width:96px; max-height:96px; object-fit:cover; object-position:center; display:block;"
                                            >

                                        @else

                                            <span class="text-3xl">
                                                📦
                                            </span>

                                        @endif

                                    </div>

                                    <div class="flex-1 min-w-0">

                                        <div class="text-lg sm:text-xl font-bold mb-2 break-words">
                                            {{ $cartItem->product->name }}
                                        </div>

                                        <div class="text-gray-500 text-sm mb-3">
                                            数量：{{ $cartItem->quantity }}
                                        </div>

                                        <div class="text-xl sm:text-2xl font-bold">
                                            ¥{{ number_format($cartItem->product->price * $cartItem->quantity) }}
                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

                {{-- right --}}
                <div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-8 lg:sticky lg:top-6">

                        <h2 class="text-2xl font-bold mb-8">
                            注文サマリー
                        </h2>

                        <div class="space-y-5 text-base sm:text-lg">

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    小計
                                </span>

                                <span class="font-bold">
                                    ¥{{ number_format($total) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    送料
                                </span>

                                <span class="font-bold">
                                    無料
                                </span>
                            </div>

                        </div>

                        <div class="border-t my-8"></div>

                        <div class="flex justify-between items-center mb-10">

                            <span class="text-xl sm:text-2xl font-bold">
                                合計
                            </span>

                            <span class="text-3xl sm:text-4xl font-bold">
                                ¥{{ number_format($total) }}
                            </span>

                        </div>

                        {{-- 配送先 --}}
                        <div class="border border-gray-200 rounded-2xl p-5 sm:p-6 mb-8">

                            <h3 class="text-2xl font-bold mb-6">
                                配送先情報
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

                                <div>

                                    <label class="block font-bold mb-2">
                                        お名前
                                    </label>

                                    <input
                                        type="text"
                                        name="customer_name"
                                        value="{{ old('customer_name', auth()->user()->name) }}"
                                        autocomplete="name"
                                        class="w-full border rounded-xl px-4 py-4 text-base
                                            @error('customer_name')
                                                border-red-500 bg-red-50
                                            @enderror"
                                    >

                                    @error('customer_name')

                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <div>

                                    <label class="block font-bold mb-2">
                                        メールアドレス
                                    </label>

                                    <input
                                        type="email"
                                        name="customer_email"
                                        value="{{ old('customer_email', auth()->user()->email) }}"
                                        autocomplete="email"
                                        class="w-full border rounded-xl px-4 py-4 text-base
                                            @error('customer_email')
                                                border-red-500 bg-red-50
                                            @enderror"
                                    >

                                    @error('customer_email')

                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <div>

                                    <label class="block font-bold mb-2">
                                        郵便番号
                                    </label>

                                    <input
                                        type="text"
                                        name="postal_code"
                                        value="{{ old('postal_code') }}"
                                        placeholder="123-4567"
                                        inputmode="numeric"
                                        autocomplete="postal-code"
                                        class="w-full border rounded-xl px-4 py-4 text-base
                                            @error('postal_code')
                                                border-red-500 bg-red-50
                                            @enderror"
                                    >

                                    @error('postal_code')

                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                                <div>

                                    <label class="block font-bold mb-2">
                                        電話番号
                                    </label>

                                    <input
                                        type="tel"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        placeholder="080-1234-5678"
                                        inputmode="tel"
                                        autocomplete="tel"
                                        pattern="0[789]0-?[0-9]{4}-?[0-9]{4}"
                                        class="w-full border rounded-xl px-4 py-4 text-base
                                            @error('phone')
                                                border-red-500 bg-red-50
                                            @enderror"
                                    >

                                    <p class="text-gray-400 text-xs mt-2">
                                        090 / 080 / 070 から始まる番号を入力できます。ハイフンあり・なし両方OKです。
                                    </p>

                                    @error('phone')

                                        <div class="text-red-500 text-sm mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                            <div class="mt-6">

                                <label class="block font-bold mb-2">
                                    住所
                                </label>

                                <input
                                    type="text"
                                    name="address"
                                    value="{{ old('address') }}"
                                    autocomplete="street-address"
                                    class="w-full border rounded-xl px-4 py-4 text-base
                                        @error('address')
                                            border-red-500 bg-red-50
                                        @enderror"
                                >

                                @error('address')

                                    <div class="text-red-500 text-sm mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                        <button type="submit"
                                class="w-full bg-[#070d16] text-white py-5 rounded-xl text-lg sm:text-xl font-bold hover:bg-gray-800 transition">
                            Stripeで支払う
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>