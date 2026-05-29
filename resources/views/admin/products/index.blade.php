<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品管理 | ShopSwift Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827]">

<div class="flex min-h-screen">

    {{-- サイドバー --}}
    <aside class="w-64 bg-[#070d16] text-white flex flex-col">

        <div class="h-20 flex items-center px-8 border-b border-white/10">
            <div>
                <div class="text-2xl font-bold">
                    ShopSwift
                </div>

                <div class="text-xs text-gray-400">
                    ADMIN PANEL
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">

            <a href="{{route('admin.dashboard')}}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">

                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>

                ダッシュボード
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10">

                <i data-lucide="package" class="w-5 h-5"></i>

                商品管理
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">

                <i data-lucide="shopping-bag" class="w-5 h-5"></i>

                注文管理
            </a>

        </nav>

    </aside>

    {{-- メイン --}}
    <main class="flex-1 p-8">

        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-3xl font-bold">
                    商品管理
                </h1>

                <p class="text-gray-500 mt-2">
                    商品の追加・編集・削除を行います
                </p>
            </div>

            <a href="{{ route('admin.products.create') }}"
               class="bg-[#070d16] text-white px-6 py-4 rounded-xl font-bold hover:bg-gray-800 transition">

                ＋ 新しい商品を追加

            </a>

        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">

            <table class="w-full">

                <thead class="bg-gray-50 border-b">

                    <tr class="text-left text-sm text-gray-500">

                        <th class="px-6 py-4">商品名</th>
                        <th class="px-6 py-4">価格</th>
                        <th class="px-6 py-4">在庫</th>
                        <th class="px-6 py-4">ステータス</th>
                        <th class="px-6 py-4">更新日</th>
                        <th class="px-6 py-4 text-right">操作</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse ($products as $product)

                        <tr class="border-b last:border-b-0 hover:bg-gray-50">

                            <td class="px-6 py-5 font-bold">
                                {{ $product->name }}
                            </td>

                            <td class="px-6 py-5">
                                ¥{{ number_format($product->price) }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $product->stock }}
                            </td>

                            <td class="px-6 py-5">

                                @if ($product->is_active)

                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                        公開中
                                    </span>

                                @else

                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                        非公開
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5 text-gray-500 text-sm">
                                {{ optional($product->updated_at)->format('Y/m/d') }}
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex justify-end gap-3">

                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-100">

                                        編集

                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.products.destroy', $product) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('削除しますか？')"
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">

                                            削除

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-16 text-center text-gray-500">

                                商品がありません。

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>