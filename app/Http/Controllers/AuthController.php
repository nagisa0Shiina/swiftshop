<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * 新規登録画面を表示する
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * 新規登録処理
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'お名前を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスはすでに登録されています。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

      $user->sendEmailVerificationNotification();

    Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('verification.notice')
            ->with('success', '確認メールを送信しました。メール内のリンクをクリックして認証を完了してください。');
    }

    /**
     * ログイン画面を表示する
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * ログイン処理
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'メールアドレスかパスワードが違います。',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if ($request->user()->is_admin) {
            return redirect()->route('admin.products.index');
        }

        if (! $request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->route('products.index');
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * メール認証待ち画面
     */
    public function verificationNotice()
    {
        return view('auth.verify-email');
    }

    /**
     * メール認証処理
     */
    public function verifyEmail(Request $request)
    {
        if (! $request->user()) {
            abort(403);
        }

        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            abort(403);
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            abort(403);
        }

        if (! $request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified();
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'メール認証が完了しました。');
    }

    /**
     * 認証メール再送信
     */
    public function resendVerificationEmail(Request $request)
    {

    // すでにメール認証が完了しているユーザーなら、
// 認証メールを再送信せずトップページへ戻す
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('products.index');
        }

        // まだメール認証が完了していないユーザーが再送信を要求した場合、
// 認証メールをもう一度送信する
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', '確認メールを再送信しました。');
    }

    /**
     * パスワードを忘れた方向けの画面を表示する
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * パスワード再設定用URLを送信する
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns'],
        ], [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'パスワード再設定用のメールを送信しました。');
        }

        return back()->withErrors([
            'email' => 'パスワード再設定メールを送信できませんでした。',
        ]);
    }

    /**
     * 新しいパスワード設定画面を表示する
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * 新しいパスワードを保存する
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => '新しいパスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
        ]);

      // 入力された email・token・新しいパスワードを使って、
// パスワード再設定が可能かLaravelが確認する。
// tokenが正しければ、新しいパスワードをDBに保存する。

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
    //もしユーザーが正常にパスワード設定終えたらログイン画面に飛ばしログインを促す。失敗したら'パスワード再設定に失敗しました。',のエラーを返す。メールアドレスは入力されたまま
        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('success', 'パスワードを再設定しました。ログインしてください。');
        }

     return back()
    ->withInput($request->only('email'))
    ->withErrors([
        'email' => 'パスワード再設定に失敗しました。',
    ]);

    }


public function destroy(Request $request)
{


$request->validated([
    'password' => ['required'],
],[
    'password.required' => 'パスワードを入力してください',
]);


$user = $request->user();

//ユーザーが入力したパスワードをチェックし一致してなければ'パスワードが一致しません'のエラーを返す。
if(! Hash::check($request->password, $user->password)){
    return back()->withErrors([
        'password' => 'パスワードが一致しません',
    ]);
}

Auth::logout();

$userId = $user->id;


$user->update([
    'name' => '退会済みユーザー',
    'email' => 'deleted_user_' . $userId . '@deleted.local',
    'password' => Hash::make(Str::random(32)),
    'remember_token' => null,
]);

$user->delete();

$request->session()->invalidate();
$request->session()->regenerateToken();

return redirect()
->route('products.index')
->with('success', '退会処理が完了しました。ご利用ありがとうございました');


}



}