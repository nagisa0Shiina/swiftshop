<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品追加 | ShopSwift Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f5f6f7] text-[#111827]">

<div class="max-w-4xl mx-auto py-10 px-4">

    <div class="mb-8">
        <h1 class="text-3xl font-bold">商品追加</h1>
        <p class="text-gray-500 mt-2">
            人気商品に設定するとトップページに表示されます。
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-100 text-red-700 p-4 rounded-xl">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.products.store') }}"
          enctype="multipart/form-data"
          class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 space-y-6">

        @csrf

        <div>
            <label class="block font-bold mb-2">商品名</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="w-full border rounded-xl px-4 py-3"
                   required>
        </div>

        <div>
            <label class="block font-bold mb-2">カテゴリ</label>
            <select name="category"
                    class="w-full border rounded-xl px-4 py-3">
                <option value="">選択してください</option>
                <option value="interior" @selected(old('category') === 'interior')>インテリア</option>
                <option value="fashion" @selected(old('category') === 'fashion')>ファッション</option>
                <option value="gadget" @selected(old('category') === 'gadget')>ガジェット</option>
                <option value="kitchen" @selected(old('category') === 'kitchen')>キッチン</option>
                <option value="beauty" @selected(old('category') === 'beauty')>ビューティー</option>
            </select>
        </div>

        <div>
            <label class="block font-bold mb-2">商品説明</label>
            <textarea name="description"
                      rows="5"
                      class="w-full border rounded-xl px-4 py-3"
                      required>{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-bold mb-2">価格</label>
                <input type="number"
                       name="price"
                       value="{{ old('price') }}"
                       min="0"
                       class="w-full border rounded-xl px-4 py-3"
                       required>
            </div>

            <div>
                <label class="block font-bold mb-2">在庫数</label>
                <input type="number"
                       name="stock"
                       value="{{ old('stock') }}"
                       min="0"
                       class="w-full border rounded-xl px-4 py-3"
                       required>
            </div>
        </div>

        <div>
            <label class="block font-bold mb-2">商品画像</label>
            <input type="file"
                   name="image"
                   accept="image/*"
                   class="w-full border rounded-xl px-4 py-3">
            <p class="text-sm text-gray-500 mt-2">
                jpg / png / webp など。最大5MB。
            </p>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 space-y-4">
            <label class="flex items-start gap-3">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       class="mt-1"
                       @checked(old('is_active', true))>
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
                       @checked(old('is_featured'))>
                <span>
                    <span class="block font-bold">人気商品としてトップページに表示する</span>
                    <span class="block text-sm text-gray-500 mt-1">
                        チェックあり：トップページの人気商品に表示。チェックなし：全商品ページのみに表示。
                    </span>
                </span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <button type="submit"
                    class="bg-[#070d16] text-white px-8 py-4 rounded-xl font-bold">
                登録する
            </button>

            <a href="{{ route('admin.products.index') }}"
               class="border px-8 py-4 rounded-xl font-bold text-center">
                戻る
            </a>
        </div>

    </form>

</div>

</body>
</html>