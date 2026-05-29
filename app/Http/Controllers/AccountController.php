<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * 退会確認画面
     */
    public function confirm()
    {
        return view('account.delete');
    }

    /**
     * 退会処理
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ], [
            'password.required' => 'パスワードを入力してください。',
        ]);

        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'パスワードが一致しません。',
                ]);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('products.index')
            ->with('success', '退会処理が完了しました。ご利用ありがとうございました。');
    }
}