<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>退会手続き | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f8f4ef] text-[#111827] overflow-x-hidden">

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    {{-- visual --}}
    <section class="flex items-center justify-center px-4 sm:px-6 md:px-10 py-8 sm:py-10 lg:p-12 bg-[#f4eee6]">

        <div class="w-full max-w-xl">

            <a href="{{ route('products.index') }}" class="inline-flex text-2xl sm:text-3xl font-bold">
                ShopSwift
            </a>

            <div class="mt-8 sm:mt-10 lg:mt-12 rounded-[2rem] min-h-[280px] sm:min-h-[360px] lg:min-h-[560px] bg-gradient-to-br from-[#f9f4ee] to-[#dfcfba] flex flex-col items-center justify-center text-center px-6 sm:px-10">

                <div class="text-6xl sm:text-7xl lg:text-8xl mb-6 lg:mb-8">
                    🕊️
                </div>

                <p class="text-gray-500 mb-4 lg:mb-5">
                    Account Delete
                </p>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-5 lg:mb-6">
                    退会手続き
                </h1>

                <p class="text-gray-600 leading-loose text-sm sm:text-base">
                    退会すると、ログインや会員機能が<br class="hidden sm:block">
                    利用できなくなります。
                </p>

            </div>

        </div>

    </section>

    {{-- form --}}
    <section class="flex items-center justify-center px-4 sm:px-6 md:px-10 py-10 sm:py-14 lg:py-12 bg-white">

        <div class="w-full max-w-[460px]">

            <a href="{{ route('mypage') }}"
               class="inline-flex items-center gap-2 text-sm font-bold mb-8 sm:mb-10">
                <span>‹</span>
                マイページへ戻る
            </a>

            <div class="mb-8 sm:mb-10">

                <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center mb-6">
                    <i data-lucide="user-x" class="w-7 h-7"></i>
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    退会しますか？
                </h1>

                <p class="text-gray-500 leading-relaxed">
                    退会後は、このアカウントでログインできなくなります。
                    安全確認のため、現在のパスワードを入力してください。
                </p>

            </div>

            <div class="bg-red-50 border border-red-100 rounded-2xl p-5 mb-6 text-sm text-red-700 leading-relaxed">
                <div class="font-bold mb-2">
                    退会前にご確認ください
                </div>

                <ul class="list-disc list-inside space-y-1">
                    <li>アカウントは退会状態になります。</li>
                    <li>同じメールアドレスで再登録できない場合があります。</li>
                    <li>注文履歴など一部データは管理上保持される場合があります。</li>
                    <li>未発送・未完了の注文がある場合は、先にお問い合わせください。</li>
                </ul>
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
                  action="{{ route('account.delete') }}"
                  class="space-y-6">

                @csrf
                @method('DELETE')

                <div>
                    <label class="block text-sm font-bold mb-2">
                        現在のパスワード
                    </label>

                    <div class="relative">
                        <i data-lucide="lock"
                           class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            id="passwordInput"
                            type="password"
                            name="password"
                            placeholder="現在のパスワード"
                            autocomplete="current-password"
                            class="w-full border border-gray-200 rounded-2xl py-4 pl-14 pr-14 text-base bg-white focus:outline-none focus:ring-2 focus:ring-red-300"
                        >

                        <button type="button"
                                id="togglePassword"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        onclick="return confirm('本当に退会しますか？この操作後、ログアウトされます。')"
                        class="w-full bg-red-500 text-white py-4 rounded-2xl font-bold hover:bg-red-600 transition">
                    退会する
                </button>

            </form>

            <div class="mt-4">
                <a href="{{ route('mypage') }}"
                   class="block w-full text-center border border-gray-300 py-4 rounded-2xl font-bold hover:bg-gray-50 transition">
                    退会せずに戻る
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
</script>

</body>
</html>