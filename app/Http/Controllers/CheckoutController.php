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
    private const FREE_SHIPPING_THRESHOLD = 10000;
    private const SHIPPING_FEE = 220;

    private function calculateSubtotal($cartItems): int
    {
        return (int) $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });
    }

    private function calculateShippingFee(int $subtotal): int
    {
        return $subtotal >= self::FREE_SHIPPING_THRESHOLD ? 0 : self::SHIPPING_FEE;
    }

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

        $subtotal = $this->calculateSubtotal($cartItems);
        $shippingFee = $this->calculateShippingFee($subtotal);
        $total = $subtotal + $shippingFee;
        $freeShippingThreshold = self::FREE_SHIPPING_THRESHOLD;

        return view('checkout.confirm', compact(
            'cartItems',
            'subtotal',
            'shippingFee',
            'total',
            'freeShippingThreshold'
        ));
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
                'postal_code' => [
                    'required',
                    'regex:/^\d{3}-?\d{4}$/',
                ],
                'phone' => [
                    'required',
                    'regex:/^0[789]0-?\d{4}-?\d{4}$/',
                ],
                'address' => [
                    'required',
                    'string',
                    'max:500',
                ],
            ],
            [
                'customer_name.required' => 'お名前を入力してください。',
                'customer_name.regex' => 'お名前に記号やメールアドレスは使用できません。',

                'customer_email.required' => 'メールアドレスを入力してください。',
                'customer_email.email' => 'メールアドレスの形式が正しくありません。',

                'postal_code.required' => '郵便番号を入力してください。',
                'postal_code.regex' => '郵便番号は 123-4567 または 1234567 の形式で入力してください。',

                'phone.required' => '電話番号を入力してください。',
                'phone.regex' => '電話番号は090・080・070から始まる正しい形式で入力してください。',

                'address.required' => '住所を入力してください。',
            ]
        );

        $digitsPhone = preg_replace('/[^0-9]/', '', $validated['phone']);
        $validated['phone'] = preg_replace(
            '/^(0[789]0)(\d{4})(\d{4})$/',
            '$1-$2-$3',
            $digitsPhone
        );

        $digitsPostalCode = preg_replace('/[^0-9]/', '', $validated['postal_code']);
        $validated['postal_code'] = preg_replace(
            '/^(\d{3})(\d{4})$/',
            '$1-$2',
            $digitsPostalCode
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

        $subtotal = $this->calculateSubtotal($cartItems);
        $shippingFee = $this->calculateShippingFee($subtotal);
        $total = $subtotal + $shippingFee;

        $order = Order::create([
            'user_id' => $user->id,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'postal_code' => $validated['postal_code'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'status' => 'pending',
            'total_amount' => $total,
            'payment_status' => 'pending',
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

        if ($shippingFee > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => '送料',
                    ],
                    'unit_amount' => $shippingFee,
                ],
                'quantity' => 1,
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
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => $total,
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
                'payment_status' => 'paid',
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