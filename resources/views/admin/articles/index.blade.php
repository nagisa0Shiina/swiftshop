<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事管理 | ShopSwift Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="min-h-screen lg:flex">

    <header class="lg:hidden sticky top-0 z-40 bg-[#070d16] text-white border-b border-white/10">
        <div class="h-16 px-4 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-xl font-bold">ShopSwift</div>
                <div class="text-[10px] text-gray-400">ADMIN PANEL</div>
            </a>

            <button type="button" id="menuButton" class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <nav id="mobileMenu" class="hidden px-4 pb-4 space-y-2 bg-[#070d16]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>ダッシュボード
            </a>

            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="package" class="w-5 h-5"></i>商品管理
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>注文管理
            </a>

                    <a href="{{ route('admin.shipping.index') }}"
            class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="truck"></i>
                <span>発送状況</span>
</a>

            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="credit-card" class="w-5 h-5"></i>決済状況
            </a>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
                <i data-lucide="newspaper" class="w-5 h-5"></i>記事管理
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10">
                    <i data-lucide="log-out" class="w-5 h-5"></i>ログアウト
                </button>
            </form>
        </nav>
    </header>

    <aside class="hidden lg:flex lg:flex-col w-64 shrink-0 bg-[#070d16] text-white min-h-screen">

        <div class="h-20 px-8 flex items-center border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-2xl font-bold">ShopSwift</div>
                <div class="text-xs text-gray-400">ADMIN PANEL</div>
            </a>
        </div>

        <nav class="px-4 py-6 space-y-2 flex-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>ダッシュボード
            </a>

            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="package" class="w-5 h-5"></i>商品管理
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>注文管理
            </a>

            <a href="{{ route('admin.shipping.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="truck" class="w-5 h-5"></i>発送状況
            </a>

            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10">
                <i data-lucide="credit-card" class="w-5 h-5"></i>決済状況
            </a>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">
                <i data-lucide="newspaper" class="w-5 h-5"></i>記事管理
            </a>
        </nav>

        <div class="px-4 py-6 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:bg-red-500/10">
                    <i data-lucide="log-out" class="w-5 h-5"></i>ログアウト
                </button>
            </form>
        </div>

    </aside>

    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold">記事管理</h1>
                <p class="text-gray-500 mt-2">お知らせ・ブログ記事を管理できます</p>
            </div>

            <a href="{{ route('admin.articles.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white px-5 sm:px-6 py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                <i data-lucide="plus" class="w-5 h-5"></i>
                新しい記事を追加
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="lg:hidden space-y-4">
            @forelse ($articles as $article)
                <div class="bg-white border border-gray-200 rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="min-w-0">
                            <h2 class="text-xl font-bold break-words">{{ $article->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $article->created_at->format('Y/m/d H:i') }}</p>
                        </div>

                        @if ($article->is_published)
                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                公開中
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-bold">
                                非公開
                            </span>
                        @endif
                    </div>

                    <p class="text-gray-500 text-sm leading-relaxed mb-5">
                        {{ $article->excerpt ?: Str::limit(strip_tags($article->body), 80) }}
                    </p>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.articles.edit', $article) }}"
                           class="inline-flex items-center justify-center gap-2 border border-gray-200 py-3 rounded-xl font-bold hover:bg-gray-50">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                            編集
                        </a>

                        <form method="POST" action="{{ route('admin.articles.destroy', $article) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('この記事を削除しますか？')"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-red-500 text-white py-3 rounded-xl font-bold hover:bg-red-600">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-2xl px-6 py-16 text-center text-gray-500">
                    記事がありません。
                </div>
            @endforelse
        </div>

        <div class="hidden lg:block bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px]">
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-left text-sm text-gray-500">
                            <th class="px-6 py-4">タイトル</th>
                            <th class="px-6 py-4">状態</th>
                            <th class="px-6 py-4">作成日</th>
                            <th class="px-6 py-4 text-right">操作</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($articles as $article)
                        <tr class="border-b last:border-b-0 hover:bg-gray-50">
                            <td class="px-6 py-5">
                                <div class="font-bold">{{ $article->title }}</div>
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ $article->excerpt ?: Str::limit(strip_tags($article->body), 80) }}
                                </div>
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">
                                @if ($article->is_published)
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                        公開中
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-bold">
                                        非公開
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-sm text-gray-500 whitespace-nowrap">
                                {{ $article->created_at->format('Y/m/d H:i') }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                       class="inline-flex items-center gap-1 px-4 py-2 border rounded-lg text-sm hover:bg-gray-100">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        編集
                                    </a>

                                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('この記事を削除しますか？')"
                                                class="inline-flex items-center gap-1 px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            削除
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-gray-500">
                                記事がありません。
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 overflow-x-auto">
            {{ $articles->links() }}
        </div>

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