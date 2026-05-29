<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class FavoriteController extends Controller
{
    /**
     * お気に入り登録 / 解除
     */
    public function toggle(Product $product)
    {
        $user = Auth::user();

        $isFavorited = $user->favoriteProducts()
            ->where('products.id', $product->id)
            ->exists();

        if ($isFavorited) {
            $user->favoriteProducts()->detach($product->id);

            return back()->with('success', 'お気に入りから削除しました。');
        }

        $user->favoriteProducts()->attach($product->id);

        return back()->with('success', 'お気に入りに追加しました。');
    }
}