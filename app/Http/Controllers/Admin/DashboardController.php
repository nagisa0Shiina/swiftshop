<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // 本日の売上
        $todaySales = Order::where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        // 総売上
        $totalSales = Order::where('status', 'paid')
            ->sum('total_amount');

        // 注文数
        $ordersCount = Order::count();

        // 商品数
        $productsCount = Product::count();

        // 在庫切れ商品数
        $outOfStockCount = Product::where('stock', '<=', 0)
            ->count();

        // 最近の注文
        // 商品名を表示するため items も読み込む
        $recentOrders = Order::with([
            'user',
            'items',
        ])
            ->latest()
            ->take(5)
            ->get();

        // 人気商品ランキング
        // product_name ごとに売上個数と売上金額を集計
        $popularProducts = OrderItem::selectRaw('
                product_name,
                SUM(quantity) as total_quantity,
                SUM(price * quantity) as total_sales
            ')
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'todaySales',
            'totalSales',
            'ordersCount',
            'productsCount',
            'outOfStockCount',
            'recentOrders',
            'popularProducts'
        ));
    }
}