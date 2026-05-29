<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
      /**
     * 一括代入許可
     */

          protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * お気に入りしたユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * お気に入りされた商品
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
