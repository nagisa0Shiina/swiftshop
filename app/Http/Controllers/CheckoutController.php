<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function confirm(Request $request)
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->withErrors([
                    'cart' => 'カートが空です。',
                ]);
        }

        foreach ($cartItems as $cartItem) {
            if (! $cartItem->product->is_active) {
                return redirect()
                    ->route('cart.index')
                    ->withErrors([
                        'cart' => '販売停止中の商品が含まれています。',
                    ]);
            }

            if ($cartItem->quantity > $cartItem->product->stock) {
                return redirect()
                    ->route('cart.index')
                    ->withErrors([
                        'cart' => '在庫数を超えている商品が含まれています。',
                    ]);
            }
        }

        $total = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        return view('checkout.confirm', compact('cartItems', 'total'));
    }

    public function store(Request $request)

    {
$validated = $request->validate(
  [
    'customer_name' => [
    'required',
    'string',
    'max:255',
    'regex:/^[ぁ-んァ-ヶ一-龯a-zA-Z\s]+$/u',
],
    'customer_email' => [
    'required',
    'email:rfc,dns',
    'max:255',
],

        // 例：123-4567
        'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],

        // 例：090-1234-5678 / 03-1234-5678
        'phone' => ['required', 'regex:/^\d{2,4}-\d{2,4}-\d{3,4}$/'],

        'address' => ['required', 'string', 'max:500'],
    ],
    [
        'customer_name.regex' => 'お名前に記号やメールアドレスは使用できません。',
        'customer_email.required' => 'メールアドレスを入力してください。',
        'customer_email.email' => 'メールアドレスの形式が正しくありません。',

        'postal_code.required' => '郵便番号を入力してください。',
        'postal_code.regex' => '郵便番号は 123-4567 の形式で入力してください。',

        'phone.required' => '電話番号を入力してください。',
        'phone.regex' => '電話番号は 090-1234-5678 の形式で入力してください。',

        'address.required' => '住所を入力してください。',
    ]
);
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = $request->user();

        $cartItems = CartItem::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->withErrors([
                    'cart' => 'カートが空です。',
                ]);
        }

        foreach ($cartItems as $cartItem) {
            if (! $cartItem->product->is_active) {
                return redirect()
                    ->route('cart.index')
                    ->withErrors([
                        'cart' => '販売停止中の商品が含まれています。',
                    ]);
            }

            if ($cartItem->quantity > $cartItem->product->stock) {
                return redirect()
                    ->route('cart.index')
                    ->withErrors([
                        'cart' => '在庫数を超えている商品が含まれています。',
                    ]);
            }
        }

        $total = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        $order = Order::create([
        'user_id' => $user->id,
        'customer_name' => $validated['customer_name'],
        'customer_email' => $validated['customer_email'],
        'postal_code' => $validated['postal_code'],
        'address' => $validated['address'],
        'phone' => $validated['phone'],
        'status' => 'pending',
        'total_amount' => $total,
        'payment_status' => 'paid',
    'shipping_status' => 'preparing',
]);
        

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product->id,
                'product_name' => $cartItem->product->name,
                'price' => $cartItem->product->price,
                'quantity' => $cartItem->quantity,
            ]);
        }

        $lineItems = [];

        foreach ($cartItems as $cartItem) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $cartItem->product->name,
                    ],
                    'unit_amount' => $cartItem->product->price,
                ],
                'quantity' => $cartItem->quantity,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => [
                'order_id' => $order->id,
                'user_id' => $user->id,
            ],
        ]);

        $order->update([
            'stripe_session_id' => $session->id,
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        $order = Order::where('stripe_session_id', $sessionId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($order->status !== 'paid') {
            $order->load('items.product');

            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            $order->update([
                'status' => 'paid',
            ]);
        }

        CartItem::where('user_id', $request->user()->id)->delete();

        return view('checkout.success', compact('order'));
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}