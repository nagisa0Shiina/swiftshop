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
        Schema::create('order_items', function (Blueprint $table) {
           // 注文商品ID
            $table->id();
             // どの注文に紐づく商品か
            $table->foreignId('order_id')->constrained()->cascadeonDlete();
            // どの商品を買ったか
            $table->foreignId('product_id')->constrained()->cascadeonDlete();
                     // 購入時の商品名
            // 後から商品名が変わっても注文履歴には当時の名前を残す
            $table->string('product_name');
                    // 購入時の価格
            // 後から商品価格が変わっても注文履歴には当時の価格を残す
            $table->integer('price');
            // 購入した数量
            $table->integer('quantity');
             // created_at / updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
