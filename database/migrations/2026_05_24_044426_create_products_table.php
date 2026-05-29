<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * products テーブルを作成する
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // 商品ID
            $table->id();
            // 商品名
            $table->string('name');
             // 商品説明
            $table->text('description')->nullable();
              // 商品価格
            // Stripeでは日本円は整数で扱う
            // 例：1000円なら 1000
            $table->integer('price');
            // 在庫数
            $table->integer('stock')->default(0);
              // 商品画像のパス
            // 例：products/sample.jpg
            $table->string('image_path')->nullable();
               // 公開状態
            // true = 表示する
            // false = 非表示
            $table->boolean('is_active')->default(false);
                // created_at / updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
