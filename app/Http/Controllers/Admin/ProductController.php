<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 商品一覧
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * 商品作成画面
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * 商品保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ], [
        'name.required' => '商品名を入力してください。',
        'price.required' => '価格を入力してください。',
        'price.integer.required' => '価格を入力してください。',
        'stock.required' => '在庫数を入力してください。',
        'stock.integer.required' => '在庫数は整数で入力してください。',
        'image.required' => '画像ファイルを選択してください。',
        'image.mimes' => '画像は jpg / jpeg / png / webp のいずれかを選択してください。',
        'image.max' => '画像サイズは2MB以内にしてください。',  
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category' => $validated['category'] ?? null,
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', '商品を追加しました。');
    }

    /**
     * 商品詳細
     */
    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * 商品編集画面
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * 商品更新
     */
    public function update(Request $request, Product $product)
    {
          $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'price' => ['required', 'integer', 'min:0'],
        'stock' => ['required', 'integer', 'min:0'],
        'imagePath' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ], [
        'name.required' => '商品名を入力してください。',
        'price.required' => '価格を入力してください。',
        'price.integer' => '価格は整数で入力してください。',
        'stock.required' => '在庫数を入力してください。',
        'stock.integer' => '在庫数は整数で入力してください。',
        'image.image' => '画像ファイルを選択してください。',
        'image.mimes' => '画像は jpg / jpeg / png / webp のいずれかを選択してください。',
        'image.max' => '画像サイズは2MB以内にしてください。',
    ]);


    $data = [
        'name' => $validated['name'],
        'description' => $validated['description'] ?? null,
        'price' => $validated['price'],
        'stock' => $validated['stock'],

    ];

    if($request->hasFile('image')) {
    if(!empty($product->image) && Storage::disk('public')->exists($product->image)){
        Storage::disk('public')->delete($product->image);
    }
        
         $data['image'] = $request->file('image')->store('product_images', 'public');
    }
    


    $product->update($data);
    

        return redirect()
            ->route('admin.products.index')
            ->with('success', '商品情報を更新しました。');
    }

    /**
     * 商品削除
     */
    public function destroy(Product $product)
    {
        $hasOrderItems = \App\Models\OrderItem::where('product_id', $product->id)->exists();
        $hasCartItems = \App\Models\CartItem::where('product_id', $product->id)->exists();

        if ($hasOrderItems || $hasCartItems) {
            $product->update([
                'is_active' => false,
                'stock' => 0,
                'is_featured' => false,
            ]);

            return redirect()
                ->route('admin.products.index')
                ->with('success', '商品を販売停止にしました。');
        }

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', '商品を完全削除しました。');
    }
}