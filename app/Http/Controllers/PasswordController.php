<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
        public function edit()
    {
        return view('settings.password');
    }

    public function update(Request $request)
    {

    $request->validate([

           'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => '現在のパスワードを入力してください。',
            'password.required' => '新しいパスワードを入力してください。',
            'password.min' => '新しいパスワードは8文字以上で入力してください。',
            'password.confirmed' => '新しいパスワード確認が一致しません。',
    ]);

    $user = $request->user();

    if(! Hash::check($request->current_password, $user->password)){

    return back()
    ->withErrors([
        'current_password' => '現在のパスワードが一致しません。',
    ]);

    }

$user->update([
    'password' => Hash::make($request->password),
]);

   return redirect()
            ->route('mypage')
            ->with('success', 'パスワードを変更しました。');



}


}
