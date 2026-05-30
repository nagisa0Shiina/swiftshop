<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事作成 | ShopSwift Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="min-h-screen lg:flex">

    {{-- mobile header --}}
    <header class="lg:hidden sticky top-0 z-40 bg-[#070d16] text-white border-b border-white/10">
        <div class="h-16 px-4 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-xl font-bold">ShopSwift</div>
                <div class="text-[10px] text-gray-400">ADMIN PANEL</div>
            </a>

            <button type="button"
                    id="menuButton"
                    class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <nav id="mobileMenu" class="hidden px-4 pb-4 space-y-2 bg-[#070d16]">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                ダッシュボード
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="package" class="w-5 h-5"></i>
                商品管理
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                注文管理
            </a>

            <a href="{{ route('admin.shipping.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="truck" class="w-5 h-5"></i>
                発送状況
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
                決済状況
            </a>

            <a href="{{ route('admin.articles.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
                <i data-lucide="newspaper" class="w-5 h-5"></i>
                記事管理
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    ログアウト
                </button>
            </form>
        </nav>
    </header>

    {{-- desktop sidebar --}}
    <aside class="hidden lg:flex lg:flex-col w-64 shrink-0 bg-[#070d16] text-white min-h-screen">
        <div class="h-20 px-8 flex items-center border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-2xl font-bold">ShopSwift</div>
                <div class="text-xs text-gray-400">ADMIN PANEL</div>
            </a>
        </div>

        <nav class="px-4 py-6 space-y-2 flex-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                ダッシュボード
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="package" class="w-5 h-5"></i>
                商品管理
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                注文管理
            </a>

            <a href="{{ route('admin.shipping.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="truck" class="w-5 h-5"></i>
                発送状況
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
                決済状況
            </a>

            <a href="{{ route('admin.articles.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
                <i data-lucide="newspaper" class="w-5 h-5"></i>
                記事管理
            </a>
        </nav>

        <div class="px-4 py-6 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    ログアウト
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold">
                    記事作成
                </h1>

                <p class="text-gray-500 mt-2">
                    お知らせ・ブログ記事を新しく作成します
                </p>
            </div>

            <a href="{{ route('admin.articles.index') }}"
               class="inline-flex items-center justify-center gap-2 border border-gray-200 bg-white px-5 py-4 rounded-xl font-bold hover:bg-gray-50">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                一覧へ戻る
            </a>
        </div>

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

        <form method="POST"
              action="{{ route('admin.articles.store') }}"
              enctype="multipart/form-data"
              class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">

            @csrf

            <div class="xl:col-span-2 bg-white border border-gray-200 rounded-2xl p-5 sm:p-8 space-y-6">

                <div>
                    <label class="block font-bold mb-2">
                        タイトル
                    </label>

                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           placeholder="例：ShopSwiftからのお知らせ"
                           class="w-full border rounded-xl px-4 py-4 text-base @error('title') border-red-500 bg-red-50 @enderror">

                    @error('title')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="block font-bold mb-2">
                        短い説明文
                    </label>

                    <textarea name="excerpt"
                              rows="3"
                              placeholder="記事一覧に表示する短い説明文です。"
                              class="w-full border rounded-xl px-4 py-4 text-base resize-y @error('excerpt') border-red-500 bg-red-50 @enderror">{{ old('excerpt') }}</textarea>

                    @error('excerpt')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="block font-bold mb-2">
                        本文
                    </label>

                    <textarea name="body"
                              rows="14"
                              placeholder="記事本文を入力してください。"
                              class="w-full border rounded-xl px-4 py-4 text-base leading-relaxed resize-y @error('body') border-red-500 bg-red-50 @enderror">{{ old('body') }}</textarea>

                    @error('body')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <aside class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-8 h-fit space-y-6 xl:sticky xl:top-8">

                <div>
                    <label class="block font-bold mb-2">
                        サムネイル画像
                    </label>

                    <input type="file"
                           name="thumbnail"
                           accept="image/*"
                           class="w-full border rounded-xl px-4 py-4 text-base bg-white @error('thumbnail') border-red-500 bg-red-50 @enderror">

                    <p class="text-gray-400 text-xs mt-2">
                        2MB以内の画像を選択してください。
                    </p>

                    @error('thumbnail')
                        <div class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="border border-gray-200 rounded-2xl p-5">
                    <label class="flex items-center justify-between gap-4 cursor-pointer">
                        <div>
                            <div class="font-bold">
                                公開する
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                ONにすると公開側の記事一覧に表示されます。
                            </div>
                        </div>

                        <input type="checkbox"
                               name="is_published"
                               value="1"
                               @checked(old('is_published'))
                               class="w-6 h-6 rounded border-gray-300">
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-[#070d16] text-white py-5 rounded-xl text-lg font-bold hover:bg-gray-800 transition">
                    記事を作成する
                </button>

            </aside>

        </form>

    </main>

</div>

<script>
    lucide.createIcons();

    const menuButton = document.getElementById('menuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            lucide.createIcons();
        });
    }
</script>

</body>
</html>