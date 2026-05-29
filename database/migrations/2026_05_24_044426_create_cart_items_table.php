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
        Schema::create('cart_items', function (Blueprint $table) {
              /**
     * cart_items テーブルを作成する
     */// カートアイテムID

            $table->id();
         // どのユーザーのカートか
         $table->foreignId('user_id')->constrained()->cascadeonDlete();
         // どの商品か
         $table->foreignId('product_id')->constrained()->cascadeonDlete();
          // カートに入れた数量
         $table->integer('quantity')->default(0);
            $table->timestamps();

             // 同じユーザーが同じ商品を2重にカート追加しないための制約
            // 例：user_id=1, product_id=3 は1行だけ
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
