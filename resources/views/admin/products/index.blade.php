<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理 | ShopSwift</title>

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

<div class="min-h-screen lg:flex">
  {{-- PC Sidebar --}}
    <aside class="admin-sidebar hidden lg:flex">

        <div class="px-8 py-8 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="block text-white">
                <div class="text-2xl font-bold leading-none">
                    ShopSwift
                </div>
                <div class="mt-3 text-xs tracking-[0.25em] text-white/50">
                    ADMIN PANEL
                </div>
            </a>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold bg-white text-[#070d16] transition">
                <i data-lucide="layout-dashboard"></i>
                <span>ダッシュボード</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="package"></i>
                <span>商品管理</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="clipboard-list"></i>
                <span>注文管理</span>
            </a>

            <a href="{{ route('admin.shipping.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="truck"></i>
                <span>発送状況</span>
            </a>

            @if (Route::has('admin.payments.index'))
                <a href="{{ route('admin.payments.index') }}"
                   class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="credit-card"></i>
                    <span>決済状況</span>
                </a>
            @else
                <a href="{{ route('admin.orders.index') }}"
                   class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="credit-card"></i>
                    <span>決済状況</span>
                </a>
            @endif

            <a href="{{ route('admin.articles.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="newspaper"></i>
                <span>記事管理</span>
            </a>

        </nav>

        <div class="px-4 py-6 border-t border-white/10 space-y-2">

            <a href="{{ route('products.index') }}"
               class="admin-sidebar-link rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="external-link"></i>
                <span>サイトを見る</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="admin-sidebar-button rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10 hover:text-white transition">
                    <i data-lucide="log-out"></i>
                    <span>ログアウト</span>
                </button>
            </form>

        </div>

    </aside>

    {{-- Mobile Header --}}
    <header class="lg:hidden sticky top-0 z-50 bg-[#070d16] text-white px-5 py-5 flex items-center justify-between">
        <div>
            <div class="text-2xl font-bold leading-none">ShopSwift</div>
            <div class="mt-2 text-xs tracking-[0.25em] text-white/50">ADMIN PANEL</div>
        </div>

        <button type="button"
                id="adminMenuOpen"
                class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center">
            <i data-lucide="menu" class="w-7 h-7"></i>
        </button>
    </header>

    {{-- Mobile Drawer --}}
    <div id="adminMobileMenu"
         class="fixed inset-0 z-[999] hidden lg:hidden">

        <div id="adminMobileOverlay"
             class="absolute inset-0 bg-black/50"></div>

        <aside class="absolute left-0 top-0 h-full w-[82%] max-w-[320px] bg-[#070d16] text-white flex flex-col">

            <div class="px-6 py-7 border-b border-white/10 flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold leading-none">ShopSwift</div>
                    <div class="mt-2 text-xs tracking-[0.25em] text-white/50">ADMIN PANEL</div>
                </div>

                <button type="button"
                        id="adminMenuClose"
                        class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold bg-white text-[#070d16]">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>ダッシュボード</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span>商品管理</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                    <span>注文管理</span>
                </a>

                <a href="{{ route('admin.shipping.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                    <i data-lucide="truck" class="w-5 h-5"></i>
                    <span>発送状況</span>
                </a>

                @if (Route::has('admin.payments.index'))
                    <a href="{{ route('admin.payments.index') }}"
                       class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                        <span>決済状況</span>
                    </a>
                @else
                    <a href="{{ route('admin.orders.index') }}"
                       class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                        <span>決済状況</span>
                    </a>
                @endif

                <a href="{{ route('admin.articles.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                    <i data-lucide="newspaper" class="w-5 h-5"></i>
                    <span>記事管理</span>
                </a>

            </nav>

            <div class="px-4 py-6 border-t border-white/10 space-y-2">

                <a href="{{ route('products.index') }}"
                   class="flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                    <i data-lucide="external-link" class="w-5 h-5"></i>
                    <span>サイトを見る</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full flex items-center gap-4 rounded-2xl px-5 py-4 text-base font-bold text-white/80 hover:bg-white/10">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span>ログアウト</span>
                    </button>
                </form>

            </div>

        </aside>

    <main class="flex-1 min-w-0 px-4 sm:px-6 lg:px-10 py-8 lg:py-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8">
            <div>
                <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">商品管理</h1>
                <p class="text-gray-500 mt-4 text-base sm:text-lg">商品の追加・編集・削除を行います</p>
            </div>

            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center justify-center gap-3 bg-[#070d16] text-white rounded-2xl px-6 py-4 font-bold shadow-sm hover:bg-gray-800 transition whitespace-nowrap">
                <i data-lucide="plus" class="w-5 h-5"></i>
                新しい商品を追加
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <section class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">商品名</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">価格</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">在庫</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">ステータス</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap">更新日</th>
                        <th class="px-6 py-5 text-gray-500 font-bold whitespace-nowrap text-right">操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($products as $product)
                        <tr class="border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition">
                            <td class="px-6 py-7 font-bold whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-7 font-bold whitespace-nowrap">¥{{ number_format($product->price) }}</td>
                            <td class="px-6 py-7 font-bold whitespace-nowrap">{{ $product->stock }}</td>

                            <td class="px-6 py-7 whitespace-nowrap">
                                @if (($product->stock ?? 0) > 0)
                                    <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold text-sm">公開中</span>
                                @else
                                    <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-700 font-bold text-sm">在庫切れ</span>
                                @endif
                            </td>

                            <td class="px-6 py-7 text-gray-500 font-bold whitespace-nowrap">
                                {{ optional($product->updated_at)->format('Y/m/d') }}
                            </td>

                            <td class="px-6 py-7">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 bg-white text-[#111827] font-bold hover:bg-gray-100 transition whitespace-nowrap">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>編集
                                    </a>

                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('この商品を削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-red-500 text-white font-bold hover:bg-red-600 transition whitespace-nowrap">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>削除
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500 font-bold">
                                商品はまだ登録されていません。
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        @if (method_exists($products, 'links'))
            <div class="mt-8">{{ $products->links() }}</div>
        @endif
    </main>
</div>



<script>
    lucide.createIcons();

    const adminMenuOpen = document.getElementById('adminMenuOpen');
    const adminMenuClose = document.getElementById('adminMenuClose');
    const adminMobileMenu = document.getElementById('adminMobileMenu');
    const adminMobileOverlay = document.getElementById('adminMobileOverlay');

    if (adminMenuOpen && adminMobileMenu) {
        adminMenuOpen.addEventListener('click', () => {
            adminMobileMenu.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    }

    function closeAdminMenu() {
        if (!adminMobileMenu) return;
        adminMobileMenu.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    if (adminMenuClose) {
        adminMenuClose.addEventListener('click', closeAdminMenu);
    }

    if (adminMobileOverlay) {
        adminMobileOverlay.addEventListener('click', closeAdminMenu);
    }
</script>


</body>
</html>