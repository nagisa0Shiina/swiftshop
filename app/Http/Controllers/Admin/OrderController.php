<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    
    
    /**
         * 注文一覧
         */


public function index()
{


$orders = Order::with([
    'user',
    'items',
])
->latest()
->paginate(10);


  return view('admin.orders.index', compact('orders'));


}


public function updateStatus(Request $request, Order $order){


    $validated = $request->validate([
        'shipping_status' => ['required', 'in:preparing,shipping,completed'],
    ]);

    $order->update([
        'shipping_status' => $validated['shipping_status'],
    ]);

    return redirect()
        ->route('admin.shipping.index')
        ->with('success', '発送状況を更新しました。');


}


public function destroy(Order $order)
{
    // 注文明細を先に削除
    $order->items()->delete();

    // 注文本体を削除
    $order->delete();

    return redirect()
        ->route('admin.orders.index')
        ->with('success', '注文データを削除しました。');
}



public function shipping()
{
    $orders = Order::latest()->paginate(10);

    return view('admin.shipping.index', compact('orders'));
}




public function payments()
{
    $orders = Order::with(['user', 'items'])
        ->latest()
        ->paginate(10);

    return view('admin.payments.index', compact('orders'));
}

public function updatePaymentStatus(Request $request, Order $order)
{
    $validated = $request->validate([
        'payment_status' => [
            'required',
            'in:pending,paid,refunded',
        ],
    ]);

    $order->update([
        'payment_status' => $validated['payment_status'],
    ]);

    return redirect()
        ->route('admin.payments.index')
        ->with('success', '決済状況を更新しました。');
}




}