<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
      /**
     * お問い合わせフォーム表示
     */

      public function index()
      {
        return view('contact.index');
      }

 /**
     * お問い合わせ送信
     */
public function send(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'subject' => ['required', 'string', 'max:255'],
        'message' => ['required', 'string', 'max:3000'],
    ]);

$adminAddress = config('mail.admin_address');

    if (! $adminAddress) {
        return back()
            ->withInput()
            ->withErrors([
                'email' => '管理者メールアドレスが設定されていません。',
            ]);
    }

    Mail::to($adminAddress)->send(
        new ContactMail($validated)
    );

    return redirect()
        ->route('contact.index')
        ->with('success', 'お問い合わせを送信しました。内容を確認のうえ、担当者よりご連絡いたします。');
}


}