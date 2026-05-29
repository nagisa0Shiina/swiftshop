<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Product $product, Request $request)
    {
        abort_if(! $product->is_active, 404);

        if ($product->stock <= 0) {
            return back()->withErrors([
                'cart' => 'この商品は在庫切れです',
            ]);
        }

        $cartItem = CartItem::firstOrNew([
            'product_id' => $product->id,
            'user_id' => $request->user()->id,
        ]);

        $cartItem->quantity = $cartItem->exists
            ? $cartItem->quantity + 1
            : 1;

        if ($cartItem->quantity > $product->stock) {
            return back()->withErrors([
                'cart' => '在庫数を超えています',
            ]);
        }

        $cartItem->save();

       $cartItem->save();

        return back()
            ->with('cart_success', 'カートに商品を追加しました');
    }

    public function update(CartItem $cartItem, Request $request)
    {   
        // 他人のカート変更禁止
        abort_if($cartItem->user_id !== $request->user()->id, 403);
        // バリデーション
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

           // 商品取得
        $product = $cartItem->product;


         // 在庫数超えチェック
        if($validated['quantity'] > $product->stock) {
            return back()->withErrors([
                'cart' => '在庫数を超えています',
            ]);
        }

    // 更新
    $cartItem->update([
    'quantity' => $validated['quantity'],
    ]);

    return back()->with('success', '数量を変更しました。');
    


    }

  /**
     * カート削除
     */

    public function destroy(CartItem $cartItem, Request $request)
    {        // 他人のカート削除禁止
        abort_if($cartItem->user_id !== $request->user()->id, 403);
        $cartItem->delete();

        return back()->with('success', 'カートから商品を削除しました。');

}


}





    