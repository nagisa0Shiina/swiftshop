<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード変更 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="w-full max-w-[900px] mx-auto bg-white min-h-screen sm:my-4 sm:border sm:border-gray-200 sm:rounded-xl sm:shadow-sm sm:overflow-hidden">

    <header class="sticky top-0 z-40 bg-white h-16 sm:h-20 px-4 sm:px-8 flex items-center justify-between border-b border-gray-100">

        <a href="{{ route('products.index') }}" class="text-xl sm:text-2xl font-bold">
            ShopSwift
        </a>

        <div class="flex items-center gap-5">
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

        <div class="mb-8">

            <h1 class="text-3xl sm:text-4xl font-bold mb-3">
                パスワード変更
            </h1>

            <p class="text-gray-500">
                現在のパスワードを確認してから、新しいパスワードに変更します。
            </p>

        </div>

        <a href="{{ route('mypage') }}"
           class="flex items-center justify-center gap-3 w-full border border-gray-200 rounded-2xl py-4 mb-8 font-bold text-lg hover:bg-gray-50">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
            マイページへ戻る
        </a>

        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('password.update') }}"
              class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-8 space-y-6">

            @csrf
            @method('PATCH')

            <div>
                <label class="block font-bold mb-2">
                    現在のパスワード
                </label>

                <input
                    type="password"
                    name="current_password"
                    autocomplete="current-password"
                    class="w-full border rounded-xl px-4 py-4 text-base
                        @error('current_password')
                            border-red-500 bg-red-50
                        @enderror"
                >

                @error('current_password')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <label class="block font-bold mb-2">
                    新しいパスワード
                </label>

                <input
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    class="w-full border rounded-xl px-4 py-4 text-base
                        @error('password')
                            border-red-500 bg-red-50
                        @enderror"
                >

                <p class="text-gray-400 text-xs mt-2">
                    8文字以上で入力してください。
                </p>

                @error('password')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <label class="block font-bold mb-2">
                    新しいパスワード確認
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    class="w-full border rounded-xl px-4 py-4 text-base"
                >
            </div>

            <button type="submit"
                    class="w-full bg-[#070d16] text-white py-5 rounded-xl text-lg font-bold hover:bg-gray-800 transition">
                パスワードを変更する
            </button>

        </form>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>