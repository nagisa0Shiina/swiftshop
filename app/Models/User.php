<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
   use HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cartItems()
{
    return $this->hasMany(CartItem::class);
}


 /**
     * 注文一覧
     */

 public function orders()

{

return $this->hasMany(Order::class);

}

 /**
     * お気に入り一覧
     */


 public function favorites()
{
    return $this->hasMany(Favorite::class);
}

 /**
     * お気に入りした商品一覧
     */


 public function favoriteProducts()
 {
    return $this->belongsToMany(Product::class, 'favorites')->withTimestamps();
 }

}
