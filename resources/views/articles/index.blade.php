<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事管理 | ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            margin: 0;
            background: #f5f6f7;
            color: #111827;
            overflow-x: hidden;
        }

        .admin-page {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
        }

        .admin-sidebar-fixed {
            width: 300px !important;
            min-width: 300px !important;
            max-width: 300px !important;
            flex: 0 0 300px !important;
            min-height: 100vh !important;
            background: #070d16 !important;
            color: #ffffff !important;
            display: flex !important;
            flex-direction: column !important;
            writing-mode: horizontal-tb !important;
            text-orientation: mixed !important;
        }

        .admin-sidebar-fixed,
        .admin-sidebar-fixed *,
        .admin-sidebar-fixed a,
        .admin-sidebar-fixed span,
        .admin-sidebar-fixed div,
        .admin-sidebar-fixed nav,
        .admin-sidebar-fixed button,
        .admin-sidebar-fixed form {
            writing-mode: horizontal-tb !important;
            text-orientation: mixed !important;
            white-space: nowrap !important;
            word-break: keep-all !important;
            overflow-wrap: normal !important;
            line-break: auto !important;
            letter-spacing: normal !important;
        }

        .admin-sidebar-logo {
            padding: 32px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-sidebar-logo a {
            display: block !important;
            text-decoration: none;
            color: inherit;
        }

        .admin-sidebar-title {
            font-size: 24px;
            line-height: 1;
            font-weight: 800;
        }

        .admin-sidebar-subtitle {
            margin-top: 12px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.25em !important;
        }

        .admin-sidebar-nav {
            flex: 1;
            padding: 24px 16px;
            overflow-y: auto;
        }

        .admin-sidebar-bottom {
            padding: 24px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-sidebar-link,
        .admin-sidebar-button {
            width: 100% !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 16px !important;
            padding: 16px 20px !important;
            margin-bottom: 8px !important;
            border-radius: 16px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            line-height: 1.2 !important;
            text-decoration: none !important;
            border: none !important;
            cursor: pointer;
            box-sizing: border-box !important;
        }

        .admin-sidebar-link svg,
        .admin-sidebar-button svg {
            width: 20px !important;
            height: 20px !important;
            min-width: 20px !important;
            flex-shrink: 0 !important;
        }

        .admin-sidebar-link span,
        .admin-sidebar-button span {
            display: inline-block !important;
            writing-mode: horizontal-tb !important;
            white-space: nowrap !important;
        }

        .admin-sidebar-link-normal,
        .admin-sidebar-button {
            color: rgba(255, 255, 255, 0.8) !important;
            background: transparent !important;
        }

        .admin-sidebar-link-normal:hover,
        .admin-sidebar-button:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.1) !important;
        }

        .admin-sidebar-link-active {
            color: #070d16 !important;
            background: #ffffff !important;
        }

        .admin-main {
            flex: 1;
            min-width: 0;
            padding: 40px;
        }

        .admin-mobile-header {
            display: none;
        }

        @media (max-width: 1023px) {
            .admin-page {
                display: block;
            }

            .admin-sidebar-fixed {
                display: none !important;
            }

            .admin-mobile-header {
                display: flex;
                position: sticky;
                top: 0;
                z-index: 40;
                background: #070d16;
                color: #ffffff;
                padding: 16px;
                align-items: center;
                justify-content: space-between;
            }

            .admin-main {
                padding: 32px 16px;
            }
        }
    </style>
</head>

<body>

<div class="admin-page">

    <aside class="admin-sidebar-fixed">

        <div class="admin-sidebar-logo">
            <a href="{{ route('admin.dashboard') }}">
                <div class="admin-sidebar-title">ShopSwift</div>
                <div class="admin-sidebar-subtitle">ADMIN PANEL</div>
            </a>
        </div>

        <nav class="admin-sidebar-nav">

            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link admin-sidebar-link-normal">
                <i data-lucide="layout-dashboard"></i>
                <span>ダッシュボード</span>
            </a>

            <a href="{{ route('admin.products.index') }}" class="admin-sidebar-link admin-sidebar-link-normal">
                <i data-lucide="package"></i>
                <span>商品管理</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="admin-sidebar-link admin-sidebar-link-normal">
                <i data-lucide="clipboard-list"></i>
                <span>注文管理</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="admin-sidebar-link admin-sidebar-link-normal">
                <i data-lucide="truck"></i>
                <span>発送状況</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="admin-sidebar-link admin-sidebar-link-normal">
                <i data-lucide="credit-card"></i>
                <span>決済状況</span>
            </a>

            <a href="{{ route('admin.articles.index') }}" class="admin-sidebar-link admin-sidebar-link-active">
                <i data-lucide="newspaper"></i>
                <span>記事管理</span>
            </a>

        </nav>

        <div class="admin-sidebar-bottom">

            <a href="{{ route('products.index') }}" class="admin-sidebar-link admin-sidebar-link-normal">
                <i data-lucide="external-link"></i>
                <span>サイトを見る</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-sidebar-button">
                    <i data-lucide="log-out"></i>
                    <span>ログアウト</span>
                </button>
            </form>

        </div>

    </aside>

    <header class="admin-mobile-header">
        <div>
            <div class="text-xl font-bold">ShopSwift</div>
            <div class="text-xs tracking-widest text-white/50">ADMIN PANEL</div>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
        </a>
    </header>

    <main class="admin-main">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8">

            <div>
                <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">
                    記事管理
                </h1>

                <p class="text-gray-500 mt-4 text-base sm:text-lg">
                    お知らせ・ブログ記事を管理できます
                </p>
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
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">状態</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">作成日</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap text-right">操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($articles as $article)

                        <tr class="border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition">

                            <td class="px-6 py-7">
                                <div class="font-bold whitespace-nowrap">
                                    {{ $article->title }}
                                </div>

                                @if (!empty($article->body))
                                    <div class="text-gray-500 text-sm mt-2 max-w-md truncate">
                                        {{ $article->body }}
                                    </div>
                                @elseif (!empty($article->content))
                                    <div class="text-gray-500 text-sm mt-2 max-w-md truncate">
                                        {{ $article->content }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-7 whitespace-nowrap">
                                @if (($article->is_published ?? false) || ($article->status ?? '') === 'published')
                                    <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold text-sm">
                                        公開中
                                    </span>
                                @else
                                    <span class="inline-flex px-4 py-2 rounded-full bg-gray-100 text-gray-700 font-bold text-sm">
                                        非公開
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-7 text-gray-500 font-bold whitespace-nowrap">
                                {{ optional($article->created_at)->format('Y/m/d H:i') }}
                            </td>

                            <td class="px-6 py-7">
                                <div class="flex items-center justify-end gap-3">

                                    @if (Route::has('admin.articles.edit'))
                                        <a href="{{ route('admin.articles.edit', $article) }}"
                                           class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 bg-white text-[#111827] font-bold hover:bg-gray-100 transition whitespace-nowrap">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                            編集
                                        </a>
                                    @endif

                                    @if (Route::has('admin.articles.destroy'))
                                        <form method="POST"
                                              action="{{ route('admin.articles.destroy', $article) }}"
                                              onsubmit="return confirm('この記事を削除しますか？');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-red-500 text-white font-bold hover:bg-red-600 transition whitespace-nowrap">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                削除
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
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        @endif

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>