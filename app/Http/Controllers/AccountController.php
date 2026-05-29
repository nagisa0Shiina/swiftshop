<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function confirm()
    {
        return view('account.delete');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ], [
            'password.required' => 'パスワードを入力してください。',
        ]);

        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'パスワードが一致しません。',
            ]);
        }

        DB::transaction(function () use ($user, $request) {
            $userId = $user->id;
            $email = $user->email;

            $orders = $user->orders()->with('items')->get();

            foreach ($orders as $order) {
                $order->items()->delete();
                $order->delete();
            }

            $user->cartItems()->delete();
            $user->favorites()->delete();

            DB::table('sessions')
                ->where('user_id', $userId)
                ->delete();

            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            Auth::logout();

            $user->forceDelete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
        });

        return redirect()
            ->route('products.index')
            ->with('success', '退会処理が完了しました。ご利用ありがとうございました。');
    }
}