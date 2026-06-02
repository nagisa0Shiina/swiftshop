<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * 一括代入許可
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'stock',
        'image',
        'is_active',
         'is_featured',
    ];


       /**
     * この商品のお気に入り情報
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }


    /**
     * この商品をお気に入りしたユーザー一覧
     */
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

}
