<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事管理 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        aside, aside * {
            writing-mode: horizontal-tb !important;
            text-orientation: mixed !important;
            word-break: keep-all !important;
            overflow-wrap: normal !important;
        }
    </style>
</head>

<body class="bg-[#f5f6f7] text-[#111827] overflow-x-hidden">

<div class="min-h-screen flex">

    <aside class="hidden lg:flex w-[300px] shrink-0 min-h-screen flex-col bg-[#070d16] text-white">
        <div class="px-8 py-8 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="block">
                <div class="text-2xl font-bold leading-none whitespace-nowrap">ShopSwift</div>
                <div class="mt-3 text-xs tracking-[0.25em] text-white/50 whitespace-nowrap">ADMIN PANEL</div>
            </a>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-row items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i><span>ダッシュボード</span>
            </a>

            <a href="{{ route('admin.products.index') }}" class="flex flex-row items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="package" class="w-5 h-5 shrink-0"></i><span>商品管理</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex flex-row items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="clipboard-list" class="w-5 h-5 shrink-0"></i><span>注文管理</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex flex-row items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="truck" class="w-5 h-5 shrink-0"></i><span>発送状況</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex flex-row items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="credit-card" class="w-5 h-5 shrink-0"></i><span>決済状況</span>
            </a>

            <a href="{{ route('admin.articles.index') }}" class="flex flex-row items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap bg-white text-[#070d16] transition">
                <i data-lucide="newspaper" class="w-5 h-5 shrink-0"></i><span>記事管理</span>
            </a>
        </nav>

        <div class="px-4 py-6 border-t border-white/10 space-y-2">
            <a href="{{ route('products.index') }}" class="flex flex-row items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="external-link" class="w-5 h-5 shrink-0"></i><span>サイトを見る</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex flex-row items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold whitespace-nowrap text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="log-out" class="w-5 h-5 shrink-0"></i><span>ログアウト</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 min-w-0 px-4 sm:px-6 lg:px-10 py-8 lg:py-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8">
            <div>
                <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">記事管理</h1>
                <p class="text-gray-500 mt-4 text-base sm:text-lg">記事の作成・編集・削除を管理できます</p>
            </div>

            @if (Route::has('admin.articles.create'))
                <a href="{{ route('admin.articles.create') }}"
                   class="inline-flex items-center justify-center gap-3 bg-[#070d16] text-white rounded-2xl px-6 py-4 font-bold shadow-sm hover:bg-gray-800 transition whitespace-nowrap">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    新しい記事を追加
                </a>
            @endif
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <section class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">タイトル</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">ステータス</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">更新日</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap text-right">操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($articles as $article)
                        <tr class="border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition">
                            <td class="px-6 py-7 font-bold whitespace-nowrap">{{ $article->title }}</td>

                            <td class="px-6 py-7 whitespace-nowrap">
                                <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold text-sm">
                                    公開中
                                </span>
                            </td>

                            <td class="px-6 py-7 text-gray-500 font-bold whitespace-nowrap">
                                {{ optional($article->updated_at)->format('Y/m/d') }}
                            </td>

                            <td class="px-6 py-7 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    @if (Route::has('admin.articles.edit'))
                                        <a href="{{ route('admin.articles.edit', $article) }}"
                                           class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 bg-white text-[#111827] font-bold hover:bg-gray-100 transition whitespace-nowrap">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>編集
                                        </a>
                                    @endif

                                    @if (Route::has('admin.articles.destroy'))
                                        <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('この記事を削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-red-500 text-white font-bold hover:bg-red-600 transition whitespace-nowrap">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>削除
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-gray-500 font-bold">
                                記事はまだ登録されていません。
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        @if (method_exists($articles, 'links'))
            <div class="mt-8">{{ $articles->links() }}</div>
        @endif
    </main>
</div>

<script>lucide.createIcons();</script>
</body>
</html>