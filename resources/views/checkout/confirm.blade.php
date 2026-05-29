<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>購入確認 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827]">

<div class="max-w-[1400px] mx-auto my-4 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

    {{-- header --}}
    <header class="h-20 px-8 flex items-center justify-between border-b border-gray-100">

        <a href="{{ route('products.index') }}"
           class="text-2xl font-bold">

            ShopSwift

        </a>

        <nav class="hidden md:flex items-center gap-12 text-sm font-medium">

            <a href="{{ route('products.index') }}">
                ホーム
            </a>

            <a href="{{ route('products.index') }}">
                商品一覧
            </a>

            <a href="{{ route('orders.index') }}">
                注文履歴
            </a>

           {{-- <a href="{{ route('cart.index') }}">
                マイページ
            </a> --}}

        </nav>

        <div class="flex items-center gap-6">

            <a href="{{ route('cart.index') }}"
               class="relative">

                <i data-lucide="shopping-cart"
                   class="w-6 h-6"></i>

                <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                </span>

            </a>

        </div>

    </header>

    {{-- main --}}
    <main class="px-8 py-8">

        <div class="mb-8">

            <h1 class="text-4xl font-bold mb-3">
                購入確認
            </h1>

            <p class="text-gray-500">
                注文内容と配送先情報を確認してください
            </p>

        </div>

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
                <div class="space-y-6">

                    @foreach ($cartItems as $cartItem)

                        <div class="bg-white border border-gray-200 rounded-2xl p-6 flex gap-5">

                            <div class="w-32 h-32 bg-gray-100 rounded-xl overflow-hidden shrink-0">

                                @if ($cartItem->product->image_path)

                                    <img
                                        src="{{ asset('storage/' . $cartItem->product->image_path) }}"
                                        class="w-full h-full object-cover"
                                    >

                                @endif

                            </div>

                            <div class="flex-1">

                                <div class="text-xl font-bold mb-2">
                                    {{ $cartItem->product->name }}
                                </div>

                                <div class="text-gray-500 text-sm mb-4">
                                    数量：{{ $cartItem->quantity }}
                                </div>

                                <div class="text-2xl font-bold">
                                    ¥{{ number_format($cartItem->product->price * $cartItem->quantity) }}
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                {{-- right --}}
                <div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-8 sticky top-6">

                        <h2 class="text-2xl font-bold mb-8">
                            注文サマリー
                        </h2>

                        <div class="space-y-5 text-lg">

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

                            <span class="text-2xl font-bold">
                                合計
                            </span>

                            <span class="text-4xl font-bold">
                                ¥{{ number_format($total) }}
                            </span>

                        </div>

                        {{-- 配送先 --}}
                        <div class="border border-gray-200 rounded-2xl p-6 mb-8">

                            <h3 class="text-2xl font-bold mb-6">
                                配送先情報
                            </h3>

                            <div class="grid md:grid-cols-2 gap-6">

                                <div>

                                    <label class="block font-bold mb-2">
                                        お名前
                                    </label>

                                    <input
                                        type="text"
                                        name="customer_name"
                                        value="{{ old('customer_name', auth()->user()->name) }}"
                                        class="w-full border rounded-xl px-4 py-3
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
                                        class="w-full border rounded-xl px-4 py-3
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
                                        class="w-full border rounded-xl px-4 py-3
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
                                        type="text"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        placeholder="090-1234-5678"
                                        class="w-full border rounded-xl px-4 py-3
                                            @error('phone')
                                                border-red-500 bg-red-50
                                            @enderror"
                                    >

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
                                    class="w-full border rounded-xl px-4 py-3
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

                        <button
                            class="w-full bg-[#070d16] text-white py-5 rounded-xl text-xl font-bold hover:bg-gray-800 transition">

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