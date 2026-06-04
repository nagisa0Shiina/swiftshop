<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * トップページ
     * 人気商品のみ表示
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::with('favorites')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%')
                        ->orWhere('category', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('products.index', compact('products', 'keyword'));
    }

    /**
     * 全商品一覧ページ
     */
    public function all(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::with('favorites')
            ->where('is_active', true)
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%')
                        ->orWhere('category', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.all', compact('products', 'keyword'));
    }

    /**
     * 商品詳細
     */
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $relatedProducts = Product::with('favorites')
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->when($product->category, function ($query) use ($product) {
                $query->where('category', $product->category);
            })
            ->latest()
            ->take(4)
            ->get();

        if ($relatedProducts->count() < 4) {
            $additionalProducts = Product::with('favorites')
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->latest()
                ->take(4 - $relatedProducts->count())
                ->get();

            $relatedProducts = $relatedProducts->concat($additionalProducts);
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }
}