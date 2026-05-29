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
           /**
     * usersテーブルに管理者判定カラムを追加
     */
        Schema::table('users', function (Blueprint $table) {
             // false = 一般ユーザー
            // true = 管理者
            $table->boolean('is_admin')->default(false)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
                /**
     * rollback時にis_adminを削除
     */
            $table->dropColumn('is_admin');
        });
    }
};
