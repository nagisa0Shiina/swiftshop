<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ | ShopSwift</title>

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

<body class="bg-[#f5f6f7] text-[#111827] pb-20 md:pb-0 overflow-x-hidden">

@if (session('success'))
    <div id="successToast"
         class="toast-in fixed top-20 left-4 right-4 sm:left-auto sm:right-6 sm:w-[380px] z-[999] bg-white border border-gray-200 shadow-xl rounded-2xl px-5 py-4 flex items-center gap-3">
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


<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-[1500px] mx-auto h-16 md:h-20 px-4 md:px-8 flex items-center justify-between gap-4">
        <a href="{{ route('products.index') }}" class="text-2xl md:text-3xl font-bold shrink-0">
            ShopSwift
        </a>

      <nav class="hidden lg:flex items-center gap-8 text-sm font-bold">
    <a href="{{ route('products.index') }}" class="hover:text-gray-500">
        ホーム
    </a>

    <a href="{{ route('products.all') }}"
       class="bg-[#070d16] text-white px-5 py-3 rounded-full hover:bg-gray-800">
        全商品を見る
    </a>

    <a href="{{ route('products.index') }}#products" class="hover:text-gray-500">
        人気商品
    </a>

    <a href="{{ route('articles.index') }}#journal" class="hover:text-gray-500">
        Journal
    </a>

    <a href="{{ route('contact.index') }}" class="hover:text-gray-500">
        お問い合わせ
    </a>

    @auth
        <a href="{{ route('mypage') }}" class="hover:text-gray-500">
            マイページ
        </a>

        <a href="{{ route('orders.index') }}" class="hover:text-gray-500">
            注文履歴
        </a>
    @endauth
</nav>

        <div class="flex items-center gap-3 md:gap-5 shrink-0">
            <form method="GET"
                  action="{{ route('products.index') }}"
                  class="hidden md:flex items-center gap-2 border border-gray-200 rounded-full px-4 py-2.5 bg-white">
                <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
                <input
                    name="keyword"
                    value="{{ $keyword ?? '' }}"
                    placeholder="人気商品を検索"
                    class="outline-none text-sm w-32 lg:w-44"
                >
            </form>

            @auth
                <a href="{{ route('cart.index') }}" class="relative">
                    <i data-lucide="shopping-cart" class="w-7 h-7"></i>
                    <span class="absolute -top-3 -right-3 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ auth()->user()->cartItems()->sum('quantity') ?? 0 }}
                    </span>
                </a>

                <div class="relative">
                    <button id="userMenuButton"
                            type="button"
                            class="w-10 h-10 rounded-full bg-[#b8946d] text-white font-bold flex items-center justify-center">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </button>

                    <div id="userMenu"
                         class="hidden absolute right-0 mt-4 w-[280px] max-w-[calc(100vw-2rem)] bg-white border border-gray-200 rounded-2xl shadow-xl overflow-hidden z-50">
                        <div class="p-5 border-b">
                            <div class="font-bold">{{ auth()->user()->name }} 様</div>
                            <div class="text-sm text-gray-500 mt-1 break-all">{{ auth()->user()->email }}</div>
                        </div>

                        <div class="py-2 text-sm">
                            <a href="{{ route('mypage') }}"
                               class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                                <i data-lucide="user" class="w-5 h-5"></i>
                                マイページ
                            </a>

                            <a href="{{ route('cart.index') }}"
                               class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                                カート
                            </a>

                            <a href="{{ route('orders.index') }}"
                               class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                                <i data-lucide="receipt-text" class="w-5 h-5"></i>
                                注文履歴
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-5 py-3 text-red-500 hover:bg-red-50">
                                    <i data-lucide="log-out" class="w-5 h-5"></i>
                                    ログアウト
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="hidden sm:flex bg-[#070d16] text-white px-5 py-3 rounded-full text-sm font-bold">
                    ログイン
                </a>

                <a href="{{ route('login') }}" class="sm:hidden">
                    <i data-lucide="user" class="w-7 h-7"></i>
                </a>
            @endauth
        </div>
    </div>

    <div class="md:hidden px-4 pb-4">
        <form method="GET"
              action="{{ route('products.index') }}"
              class="flex items-center gap-2 border border-gray-200 rounded-full px-4 py-3 bg-white">
            <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
            <input
                name="keyword"
                value="{{ $keyword ?? '' }}"
                placeholder="人気商品を検索する"
                class="outline-none text-sm w-full"
            >
        </form>
    </div>
</header>
<main class="max-w-[1400px] mx-auto px-4 sm:px-6 md:px-8 py-8 md:py-12">

    <section class="mb-8">
        <div class="bg-[#f8f4ef] rounded-3xl p-8 md:p-12">
            <div class="text-gray-500 mb-3">Contact</div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                お問い合わせ
            </h1>

            <p class="text-gray-600 leading-relaxed max-w-2xl">
                商品やご注文、サービスについてご不明点がありましたら、
                下記フォームよりお気軽にお問い合わせください。
            </p>
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-8 items-start">

        <form method="POST"
              action="{{ route('contact.send') }}"
              class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8 space-y-6">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-2xl p-5">
                    <div class="font-bold mb-2">入力内容を確認してください</div>

                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block font-bold mb-2">
                    お名前 <span class="text-red-500 text-sm">必須</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name', auth()->user()->name ?? '') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none focus:border-[#070d16]"
                       placeholder="山田 太郎">
            </div>

            <div>
                <label class="block font-bold mb-2">
                    メールアドレス <span class="text-red-500 text-sm">必須</span>
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email', auth()->user()->email ?? '') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none focus:border-[#070d16]"
                       placeholder="example@example.com">
            </div>

            <div>
                <label class="block font-bold mb-2">
                    件名 <span class="text-red-500 text-sm">必須</span>
                </label>
                <input type="text"
                       name="subject"
                       value="{{ old('subject') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none focus:border-[#070d16]"
                       placeholder="商品についてのお問い合わせ">
            </div>

            <div>
                <label class="block font-bold mb-2">
                    お問い合わせ内容 <span class="text-red-500 text-sm">必須</span>
                </label>
                <textarea name="message"
                          rows="8"
                          class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none focus:border-[#070d16]"
                          placeholder="お問い合わせ内容をご入力ください。">{{ old('message') }}</textarea>
                <p class="text-sm text-gray-500 mt-2">
                    最大3000文字まで入力できます。
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit"
                        class="bg-[#070d16] text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                    送信する
                </button>

                <a href="{{ route('products.index') }}"
                   class="border border-gray-300 px-8 py-4 rounded-xl font-bold text-center hover:bg-gray-50 transition">
                    トップへ戻る
                </a>
            </div>
        </form>

        <aside class="space-y-6">

            <div class="bg-white border border-gray-200 rounded-3xl p-6 md:p-8">
                <h2 class="text-2xl font-bold mb-5">
                    お問い合わせ前に
                </h2>

                <div class="space-y-5 text-sm text-gray-600 leading-relaxed">
                    <div class="flex gap-3">
                        <i data-lucide="clock" class="w-5 h-5 shrink-0 text-gray-700"></i>
                        <div>
                            <div class="font-bold text-[#111827] mb-1">返信について</div>
                            <p>内容を確認後、通常2〜3営業日以内にご連絡いたします。</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <i data-lucide="mail" class="w-5 h-5 shrink-0 text-gray-700"></i>
                        <div>
                            <div class="font-bold text-[#111827] mb-1">メール受信設定</div>
                            <p>迷惑メール設定により返信が届かない場合があります。</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <i data-lucide="shopping-bag" class="w-5 h-5 shrink-0 text-gray-700"></i>
                        <div>
                            <div class="font-bold text-[#111827] mb-1">ご注文について</div>
                            <p>注文番号がある場合は、本文に記載いただくと確認がスムーズです。</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[#070d16] text-white rounded-3xl p-6 md:p-8">
                <h2 class="text-2xl font-bold mb-4">
                    ShopSwift
                </h2>

                <p class="text-sm text-gray-300 leading-relaxed mb-6">
                    暮らしを、もっと心地よく。商品やサービスについて、お気軽にご相談ください。
                </p>

                <a href="{{ route('products.all') }}"
                   class="inline-flex items-center justify-center bg-white text-[#070d16] px-5 py-3 rounded-xl font-bold">
                    商品を見る
                </a>
            </div>

        </aside>

    </section>

</main>

<footer class="border-t bg-white mt-10">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 md:px-8 py-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-sm">
        <div>
            <div class="text-xl font-bold mb-4">ShopSwift</div>
            <p class="text-gray-600 leading-relaxed">
                暮らしを、もっと心地よく。<br>
                シンプルでやさしい毎日をお届けします。
            </p>
        </div>

        <div>
            <div class="font-bold mb-4">ショップ</div>
            <div class="space-y-2 text-gray-600">
                <a href="{{ route('products.all') }}" class="block hover:text-black">全商品一覧</a>
                <a href="{{ route('products.index') }}#products" class="block hover:text-black">人気商品</a>
                <a href="{{ auth()->check() ? route('cart.index') : route('login') }}" class="block hover:text-black">カート</a>
            </div>
        </div>

        <div>
            <div class="font-bold mb-4">サポート</div>
            <div class="space-y-2 text-gray-600">
                <a href="{{ route('contact.index') }}" class="block hover:text-black">お問い合わせ</a>
                <a href="#" class="block hover:text-black">利用規約</a>
                <a href="#" class="block hover:text-black">プライバシーポリシー</a>
            </div>
        </div>

        <div>
            <div class="font-bold mb-4">アカウント</div>
            <div class="space-y-2 text-gray-600">
                @auth
                    <a href="{{ route('mypage') }}" class="block hover:text-black">マイページ</a>
                    <a href="{{ route('orders.index') }}" class="block hover:text-black">注文履歴</a>
                @else
                    <a href="{{ route('login') }}" class="block hover:text-black">ログイン</a>
                    <a href="{{ route('register') }}" class="block hover:text-black">新規登録</a>
                @endauth
            </div>
        </div>
    </div>
</footer>

<nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-gray-200 z-50 grid grid-cols-4 text-xs">
    <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="home" class="w-5 h-5"></i>
        ホーム
    </a>

    <a href="{{ route('products.all') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="layout-grid" class="w-5 h-5"></i>
        全商品
    </a>

    <a href="{{ route('contact.index') }}" class="flex flex-col items-center justify-center gap-1 font-bold">
        <i data-lucide="mail" class="w-5 h-5"></i>
        問合せ
    </a>

    <a href="{{ auth()->check() ? route('mypage') : route('login') }}"
       class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="user" class="w-5 h-5"></i>
        {{ auth()->check() ? 'マイページ' : 'ログイン' }}
    </a>
</nav>

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