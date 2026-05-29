<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新しいパスワード設定 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f8f4ef] text-[#111827] overflow-x-hidden">

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <section class="flex items-center justify-center px-4 sm:px-6 md:px-10 py-8 sm:py-10 lg:p-12 bg-[#f4eee6]">
        <div class="w-full max-w-xl">

            <a href="{{ route('products.index') }}" class="inline-flex text-2xl sm:text-3xl font-bold">
                ShopSwift
            </a>

            <div class="mt-8 sm:mt-10 lg:mt-12 rounded-[2rem] min-h-[280px] sm:min-h-[360px] lg:min-h-[560px] bg-gradient-to-br from-[#f9f4ee] to-[#dfcfba] flex flex-col items-center justify-center text-center px-6 sm:px-10">

                <div class="text-6xl sm:text-7xl lg:text-8xl mb-6 lg:mb-8">
                    🔑
                </div>

                <p class="text-gray-500 mb-4 lg:mb-5">
                    New Password
                </p>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-5 lg:mb-6">
                    新しいパスワードを<br>
                    設定しましょう。
                </h1>

                <p class="text-gray-600 leading-loose text-sm sm:text-base">
                    安全のため、他サービスで使っていない<br class="hidden sm:block">
                    パスワードを設定してください。
                </p>

            </div>

        </div>
    </section>

    <section class="flex items-center justify-center px-4 sm:px-6 md:px-10 py-10 sm:py-14 lg:py-12 bg-white">

        <div class="w-full max-w-[440px]">

            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 text-sm font-bold mb-8 sm:mb-10">
                <span>‹</span>
                ログインへ戻る
            </a>

            <div class="mb-8 sm:mb-10">

                <div class="w-14 h-14 rounded-2xl bg-[#f8f4ef] flex items-center justify-center mb-6">
                    <i data-lucide="lock-keyhole" class="w-7 h-7"></i>
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    パスワード再設定
                </h1>

                <p class="text-gray-500 leading-relaxed">
                    新しいパスワードを入力してください。
                    設定後はログイン画面から再度ログインできます。
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
                  action="{{ route('password.store') }}"
                  class="space-y-6">

                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ old('email', $email) }}">

                <div>
                    <label class="block text-sm font-bold mb-2">
                        メールアドレス
                    </label>

                    <div class="relative">
                        <i data-lucide="mail"
                           class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            type="email"
                            value="{{ old('email', $email) }}"
                            disabled
                            class="w-full border border-gray-200 rounded-2xl py-4 pl-14 pr-4 text-base bg-gray-50 text-gray-500"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">
                        新しいパスワード
                    </label>

                    <div class="relative">
                        <i data-lucide="lock"
                           class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            id="passwordInput"
                            type="password"
                            name="password"
                            placeholder="8文字以上"
                            autocomplete="new-password"
                            class="w-full border border-gray-200 rounded-2xl py-4 pl-14 pr-14 text-base bg-white focus:outline-none focus:ring-2 focus:ring-[#b8946d]"
                        >

                        <button type="button"
                                id="togglePassword"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        8文字以上で入力してください。
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">
                        新しいパスワード確認
                    </label>

                    <div class="relative">
                        <i data-lucide="shield-check"
                           class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            id="passwordConfirmationInput"
                            type="password"
                            name="password_confirmation"
                            placeholder="もう一度入力"
                            autocomplete="new-password"
                            class="w-full border border-gray-200 rounded-2xl py-4 pl-14 pr-14 text-base bg-white focus:outline-none focus:ring-2 focus:ring-[#b8946d]"
                        >

                        <button type="button"
                                id="togglePasswordConfirmation"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-[#070d16] text-white py-4 rounded-2xl font-bold hover:bg-gray-800 transition">
                    パスワードを再設定する
                </button>

            </form>

            <div class="mt-8 text-center text-sm text-gray-500">
                再設定メールをもう一度送りたい場合は

                <a href="{{ route('password.request') }}"
                   class="font-bold text-[#111827] underline">
                    こちら
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

    const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
    const passwordConfirmationInput = document.getElementById('passwordConfirmationInput');

    if (togglePasswordConfirmation && passwordConfirmationInput) {
        togglePasswordConfirmation.addEventListener('click', () => {
            const isPassword = passwordConfirmationInput.type === 'password';

            passwordConfirmationInput.type = isPassword ? 'text' : 'password';

            togglePasswordConfirmation.innerHTML = isPassword
                ? '<i data-lucide="eye-off" class="w-5 h-5"></i>'
                : '<i data-lucide="eye" class="w-5 h-5"></i>';

            lucide.createIcons();
        });
    }
</script>

</body>
</html>