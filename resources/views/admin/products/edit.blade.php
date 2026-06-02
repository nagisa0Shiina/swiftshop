<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品編集 | ShopSwift Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f5f6f7] text-[#111827]">

<div class="flex min-h-screen">

    <aside class="hidden lg:flex w-64 bg-[#070d16] text-white flex-col">
        <div class="h-20 flex items-center px-8 border-b border-white/10">
            <div>
                <div class="text-2xl font-bold">ShopSwift</div>
                <div class="text-xs text-gray-400">ADMIN PANEL</div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
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

    <main class="flex-1 p-4 md:p-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold">商品編集</h1>
                <p class="text-gray-500 mt-2">
                    商品情報・画像・公開状態・トップ表示設定を編集します。
                </p>
            </div>

            <a href="{{ route('admin.products.index') }}"
               class="border px-6 py-3 rounded-xl font-bold hover:bg-gray-100 text-center">
                商品一覧へ戻る
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-700 p-4 rounded-xl">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.products.update', $product) }}"
              enctype="multipart/form-data"
              class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 space-y-6">

            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold mb-2">商品名</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $product->name) }}"
                       class="w-full border rounded-xl px-4 py-3"
                       required>
            </div>

            <div>
                <label class="block font-bold mb-2">カテゴリ</label>
                <select name="category"
                        class="w-full border rounded-xl px-4 py-3">
                    <option value="">選択してください</option>
                    <option value="interior" @selected(old('category', $product->category) === 'interior')>インテリア</option>
                    <option value="fashion" @selected(old('category', $product->category) === 'fashion')>ファッション</option>
                    <option value="gadget" @selected(old('category', $product->category) === 'gadget')>ガジェット</option>
                    <option value="kitchen" @selected(old('category', $product->category) === 'kitchen')>キッチン</option>
                    <option value="beauty" @selected(old('category', $product->category) === 'beauty')>ビューティー</option>
                </select>
            </div>

            <div>
                <label class="block font-bold mb-2">商品説明</label>
                <textarea name="description"
                          rows="5"
                          class="w-full border rounded-xl px-4 py-3"
                          required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold mb-2">価格</label>
                    <input type="number"
                           name="price"
                           value="{{ old('price', $product->price) }}"
                           min="0"
                           class="w-full border rounded-xl px-4 py-3"
                           required>
                </div>

                <div>
                    <label class="block font-bold mb-2">在庫数</label>
                    <input type="number"
                           name="stock"
                           value="{{ old('stock', $product->stock) }}"
                           min="0"
                           class="w-full border rounded-xl px-4 py-3"
                           required>
                </div>
            </div>

            <div>
                <label class="block font-bold mb-2">現在の画像</label>

                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-40 h-40 object-cover rounded-xl border mb-4">
                @else
                    <div class="w-40 h-40 bg-gray-100 rounded-xl border flex items-center justify-center text-gray-400 mb-4">
                        No Image
                    </div>
                @endif

                <input type="file"
                       name="image"
                       accept="image/*"
                       class="w-full border rounded-xl px-4 py-3">

                <p class="text-sm text-gray-500 mt-2">
                    新しい画像を選択すると、現在の画像と差し替えます。
                </p>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 space-y-4">
                <label class="flex items-start gap-3">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           class="mt-1"
                           @checked(old('is_active', $product->is_active))>

                    <span>
                        <span class="block font-bold">公開する</span>
                        <span class="block text-sm text-gray-500 mt-1">
                            チェックありの商品だけユーザー側に表示します。
                        </span>
                    </span>
                </label>

                <label class="flex items-start gap-3">
                    <input type="checkbox"
                           name="is_featured"
                           value="1"
                           class="mt-1"
                           @checked(old('is_featured', $product->is_featured))>

                    <span>
                        <span class="block font-bold">人気商品としてトップページに表示する</span>
                        <span class="block text-sm text-gray-500 mt-1">
                            チェックあり：トップページの人気商品に表示。
                        </span>
                        <span class="block text-sm text-gray-500">
                            チェックなし：全商品ページのみに表示。
                        </span>
                    </span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit"
                        class="bg-[#070d16] text-white px-8 py-4 rounded-xl font-bold">
                    更新する
                </button>

                <a href="{{ route('admin.products.index') }}"
                   class="border px-8 py-4 rounded-xl font-bold text-center">
                    キャンセル
                </a>
            </div>

        </form>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>