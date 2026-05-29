<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
     /**
     * 一括代入許可
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];
        /**
     * 商品リレーション
     *
     * cart_items.product_id
     * ↓
     * products.id
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
     /**
     * ユーザーリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
