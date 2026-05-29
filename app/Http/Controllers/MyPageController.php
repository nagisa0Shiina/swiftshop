<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::with('items')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $recentOrders = $orders->take(3);

        $orderCount = $orders->count();

        $totalAmount = $orders->sum('total_amount');

        $totalItems = $orders->sum(function ($order) {
            return $order->items->sum('quantity');
        });

        $favoriteProducts = $user->favoriteProducts()
            ->where('is_active', true)
            ->latest('favorites.created_at')
            ->take(4)
            ->get();

        $favoriteCount = $user->favoriteProducts()
            ->where('is_active', true)
            ->count();

        return view('mypage.index', [
            'user' => $user,
            'recentOrders' => $recentOrders,
            'orderCount' => $orderCount,
            'totalAmount' => $totalAmount,
            'totalItems' => $totalItems,
            'favoriteProducts' => $favoriteProducts,
            'favoriteCount' => $favoriteCount,
        ]);
    }
}