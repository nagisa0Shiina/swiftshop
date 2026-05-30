<?php

use App\Http\Controllers\AuthController;
// use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 公開ページ
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/all', [ProductController::class, 'all'])
    ->name('products.all');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact.send');

Route::view('/terms', 'pages.terms')
    ->name('terms');

Route::view('/privacy', 'pages.privacy')
    ->name('privacy');

Route::view('/commercial', 'pages.commercial')
    ->name('commercial');

Route::view('/articles', 'articles.index')
    ->name('articles.index');

Route::view('/articles/morning-routine', 'articles.morning-routine')
    ->name('articles.morning-routine');

Route::view('/articles/aroma-humidifier', 'articles.aroma-humidifier')
    ->name('articles.aroma-humidifier');

Route::view('/articles/free-shipping', 'articles.free-shipping')
    ->name('articles.free-shipping');

/*
|--------------------------------------------------------------------------
| メール認証リンク
|--------------------------------------------------------------------------
| 未ログイン状態でもメール内リンクを踏めるように auth 外へ置く
|--------------------------------------------------------------------------
*/

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

/*
|--------------------------------------------------------------------------
| 未ログインのみ
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->middleware('throttle:5,1')
        ->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->middleware('throttle:5,1')
        ->name('password.store');
});

/*
|--------------------------------------------------------------------------
| ログイン済みのみ
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/email/verify', [AuthController::class, 'verificationNotice'])
        ->name('verification.notice');

    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Route::get('/settings/password', [PasswordController::class, 'edit'])
    //     ->name('password.edit');

    // Route::put('/settings/password', [PasswordController::class, 'update'])
    //     ->middleware('throttle:5,1')
    //     ->name('password.update');

    Route::get('/account/delete', [AccountController::class, 'confirm'])
        ->name('account.delete.confirm');

    Route::delete('/account/delete', [AccountController::class, 'destroy'])
        ->middleware('throttle:5,1')
        ->name('account.delete');
});

/*
|--------------------------------------------------------------------------
| ログイン済み + メール認証済みのみ
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [MyPageController::class, 'index'])
        ->name('mypage');

    Route::post('/favorites/{product}', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/{product}', [CartController::class, 'store'])
        ->name('cart.store');

    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

    Route::get('/checkout/confirm', [CheckoutController::class, 'confirm'])
        ->name('checkout.confirm');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    Route::get('/checkout/success', [CheckoutController::class, 'success'])
        ->name('checkout.success');

    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])
        ->name('checkout.cancel');

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');
});

/*
|--------------------------------------------------------------------------
| 管理者のみ
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', AdminProductController::class);

        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])
            ->name('orders.destroy');

        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        Route::patch('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])
            ->name('orders.updatePaymentStatus');

        Route::get('/shipping', [AdminOrderController::class, 'shipping'])
            ->name('shipping.index');

        Route::get('/payments', [AdminOrderController::class, 'payments'])
            ->name('payments.index');
    });