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
     * 新規登録画面を表示
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * 新規登録処理
     *
     * 登録後はログインさせず、認証メールを送ってログイン画面へ戻す
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

        return redirect()
            ->route('login')
            ->with('success', '確認メールを送信しました。メール認証を完了してからログインしてください。');
    }

    /**
     * ログイン画面を表示
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * ログイン処理
     *
     * 未認証ユーザーはログイン不可
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

        if (! $request->user()->hasVerifiedEmail()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'メール認証が完了していません。メール内のリンクから認証を完了してください。',
                ])
                ->onlyInput('email');
        }

        if ($request->user()->is_admin) {
            return redirect()->route('admin.products.index');
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
     *
     * 今回の仕様では基本使わないが、再送信用として残す
     */
    public function verificationNotice()
    {
        return view('auth.verify-email');
    }

    /**
     * メール認証処理
     *
     * 未ログイン状態でも認証リンクを踏めるようにする
     */
    public function verifyEmail(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()
            ->route('login')
            ->with('success', 'メール認証が完了しました。ログインしてください。');
    }

    /**
     * 認証メール再送信
     *
     * ログイン済み未認証ユーザー用
     */
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('products.index');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', '確認メールを再送信しました。');
    }

    /**
     * パスワードを忘れた方向け画面
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * パスワード再設定メール送信
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

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'パスワード再設定メールを送信できませんでした。',
            ]);
    }

    /**
     * 新しいパスワード設定画面
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * 新しいパスワードを保存
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'メールアドレスが確認できません。',
            'email.email' => '有効なメールアドレスではありません。',
            'password.required' => '新しいパスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
        ]);

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
}