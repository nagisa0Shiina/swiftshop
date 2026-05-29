<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
             //注文ID
            $table->id();
            // 注文したユーザー
            $table->foreignId('user_id')->constrained()->cascadeonDlete();
             // 注文合計金額
            $table->integer('total_amount');
            // 注文状態
            // pending = 決済待ち
            // paid = 決済済み
            // canceled = キャンセル
            $table->string('status')->default('pending');
              // StripeのCheckout Session ID
            // 決済完了確認で使う
            $table->string('stripe_session_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
