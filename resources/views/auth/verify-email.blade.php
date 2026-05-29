<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証 | ShopSwift</title>

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
         class="toast-in fixed top-5 left-4 right-4 sm:left-auto sm:right-6 sm:w-[380px] z-[999] bg-white border border-gray-200 shadow-xl rounded-2xl px-5 py-4 flex items-center gap-3">
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
                    ✉️
                </div>

                <p class="text-gray-500 mb-4 lg:mb-5">
                    Verify your email
                </p>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-5 lg:mb-6">
                    メール認証を<br>
                    完了してください。
                </h1>

                <p class="text-gray-600 leading-loose text-sm sm:text-base">
                    登録したメールアドレス宛に、<br class="hidden sm:block">
                    認証リンクを送信しました。
                </p>
            </div>
        </div>
    </section>

    <section class="flex items-center justify-center px-4 sm:px-6 md:px-10 py-10 sm:py-14 lg:py-12 bg-white">
        <div class="w-full max-w-[460px]">

            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 text-sm font-bold mb-8 sm:mb-10">
                <span>‹</span>
                ShopSwiftへ戻る
            </a>

            <div class="mb-8 sm:mb-10">
                <div class="w-14 h-14 rounded-2xl bg-[#f8f4ef] flex items-center justify-center mb-6">
                    <i data-lucide="mail-check" class="w-7 h-7"></i>
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                    メールを確認してください
                </h1>

                <p class="text-gray-500 leading-relaxed">
                    {{ auth()->user()->email }} 宛に認証メールを送信しました。
                    メール内のリンクをクリックすると、購入・マイページ・お気に入り機能が使えるようになります。
                </p>
            </div>

            <div class="bg-[#f8f4ef] border border-[#eadfd2] rounded-2xl p-5 mb-6 text-sm text-gray-700 leading-relaxed">
                <div class="font-bold mb-2">
                    メールが届かない場合
                </div>

                <ul class="list-disc list-inside space-y-1">
                    <li>迷惑メールフォルダを確認してください。</li>
                    <li>メールアドレスに間違いがないか確認してください。</li>
                    <li>下のボタンから認証メールを再送信できます。</li>
                </ul>
            </div>

            <form method="POST"
                  action="{{ route('verification.send') }}"
                  class="mb-4">
                @csrf

                <button type="submit"
                        class="w-full bg-[#070d16] text-white py-4 rounded-2xl font-bold hover:bg-gray-800 transition">
                    認証メールを再送信する
                </button>
            </form>

            <form method="POST"
                  action="{{ route('logout') }}"
                  class="mb-6">
                @csrf

                <button type="submit"
                        class="w-full border border-gray-300 py-4 rounded-2xl font-bold hover:bg-gray-50 transition">
                    ログアウトする
                </button>
            </form>

            <div class="text-center text-sm text-gray-500">
                認証済みの場合は
                <a href="{{ route('products.index') }}"
                   class="font-bold text-[#111827] underline">
                    トップページへ戻る
                </a>
            </div>

        </div>
    </section>

</div>

<script>
    lucide.createIcons();

    const successToast = document.getElementById('successToast');

    if (successToast) {
        setTimeout(() => {
            successToast.style.opacity = '0';
            successToast.style.transform = 'translateY(-18px)';
            successToast.style.transition = '.4s';

            setTimeout(() => {
                successToast.remove();
            }, 400);
        }, 3000);
    }
</script>

</body>
</html>