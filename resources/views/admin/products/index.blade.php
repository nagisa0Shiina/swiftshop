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