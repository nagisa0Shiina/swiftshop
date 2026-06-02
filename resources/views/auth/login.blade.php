<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .toast-in {
            animation: toastIn .45s ease forwards;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(-16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-[#f8f4ef] text-[#111827] overflow-x-hidden">

@if (session('success'))
    <div id="successToast"
         class="toast-in fixed top-5 left-4 right-4 sm:left-auto sm:right-6 sm:w-[360px] z-[999] bg-white border border-gray-200 shadow-xl rounded-2xl px-5 py-4 flex items-center gap-3">
        <div class="w-9 h-9 shrink-0 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold">
            ✓
        </div>

        <div class="min-w-0">
            <div class="font-bold text-green-700">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <section class="flex items-center justify-center px-4 sm:px-6 md:px-10 py-8 sm:py-10 lg:p-12 bg-[#f4eee6]">

        <div class="w-full max-w-xl">

            <a href="{{ route('products.index') }}" class="inline-flex text-2xl sm:text-3xl font-bold">
                ShopSwift
            </a>

            <div class="mt-8 sm:mt-10 lg:mt-12 rounded-[2rem] min-h-[280px] sm:min-h-[360px] lg:min-h-[560px] bg-gradient-to-br from-[#f9f4ee] to-[#dfcfba] flex flex-col items-center justify-center text-center px-6 sm:px-10">

                <div class="text-6xl sm:text-7xl lg:text-8xl mb-6 lg:mb-8">
                    🪴
                </div>

                <p class="text-gray-500 mb-4 lg:mb-5">
                    Welcome back
                </p>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-5 lg:mb-6">
                    暮らしを、<br>
                    もっと心地よく。
                </h1>

                <p class="text-gray-600 leading-loose text-sm sm:text-base">
                    お気に入りの商品や注文履歴を、<br class="hidden sm:block">
                    いつでも確認できます。
                </p>

            </div>

        </div>

    </section>

    <section class="flex items-center justify-center px-4 sm:px-6 md:px-10 py-10 sm:py-14 lg:py-12 bg-white">

        <div class="w-full max-w-[440px]">

            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 text-sm font-bold mb-8 sm:mb-10">
                <span>‹</span>
                ShopSwiftへ戻る
            </a>

            <div class="mb-8 sm:mb-10">

                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    ログイン
                </h1>

                <p class="text-gray-500 leading-relaxed">
                    アカウントにログインして、お買い物を続けましょう。
                </p>

            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-5 py-4 rounded-2xl text-sm">
                    <div class="font-bold mb-2">
                        入力内容を確認してください
                    </div>

                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('login') }}"
                  class="space-y-6">

                @csrf

                <div>
                    <label class="block text-sm font-bold mb-2">
                        メールアドレス
                    </label>

                    <div class="relative">
                        <i data-lucide="mail"
                           class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="example@example.com"
                            autocomplete="email"
                            class="w-full border border-gray-200 rounded-2xl py-4 pl-14 pr-4 text-base bg-white focus:outline-none focus:ring-2 focus:ring-[#b8946d]"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">
                        パスワード
                    </label>

                    <div class="relative">
                        <i data-lucide="lock"
                           class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            id="passwordInput"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            class="w-full border border-gray-200 rounded-2xl py-4 pl-14 pr-14 text-base bg-white focus:outline-none focus:ring-2 focus:ring-[#b8946d]"
                        >

                        <button type="button"
                                id="togglePassword"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
                <div class="flex items-center justify-between">
                    <label for="remember" class="inline-flex items-center gap-2 cursor-pointer">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="rounded border-gray-300 text-[#070d16] shadow-sm focus:ring-[#070d16]"
                            {{ old('remember') ? 'checked' : '' }}
                        >

                        <span class="text-sm font-bold text-gray-600">
                            ログイン状態を保持する
                        </span>
                    </label>
                </div>

                    <a href="{{ route('password.request') }}"
                       class="font-bold text-[#111827] hover:underline">
                        パスワードを忘れた方
                    </a>

                </div>

                <button type="submit"
                        class="w-full bg-[#070d16] text-white py-4 rounded-2xl font-bold hover:bg-gray-800 transition">
                    ログイン
                </button>

            </form>

            <div class="mt-8 text-center text-sm text-gray-500">
                アカウントをお持ちでないですか？

                <a href="{{ route('register') }}"
                   class="font-bold text-[#111827] underline">
                    新規登録
                </a>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('products.all') }}"
                   class="text-sm font-bold text-gray-500 hover:text-[#111827]">
                    ログインせずに商品を見る
                </a>
            </div>

        </div>

    </section>

</div>

<script>
    lucide.createIcons();

    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            togglePassword.innerHTML = isPassword
                ? '<i data-lucide="eye-off" class="w-5 h-5"></i>'
                : '<i data-lucide="eye" class="w-5 h-5"></i>';

            lucide.createIcons();
        });
    }

    const successToast = document.getElementById('successToast');

    if (successToast) {
        setTimeout(() => {
            successToast.style.opacity = '0';
            successToast.style.transform = 'translateY(-18px)';
            successToast.style.transition = '.4s';

            setTimeout(() => {
                successToast.remove();
            }, 400);
        }, 2500);
    }
</script>

</body>
</html>