<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     /**
     * 一括代入許可
     */
    protected $fillable = [
    'user_id',
    'customer_name',
    'customer_email',
    'postal_code',
    'address',
    'phone',
    'status',
    'total_amount',
    'stripe_session_id',
    'payment_status',
    'shipping_status'
    ];


       /**
     * 注文商品一覧
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
        /**
     * 注文ユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
