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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->afetr('user_id');
            $table->string('customer_email')->nullable()->afetr('customer_name');
            $table->string('postal_code')->nullable()->afetr('customer_email');
            $table->string('address')->nullable()->afetr('postal_code');
            $table->string('phone')->nullable()->afetr('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn([
                'customer_name',
                'customer_email',
                'postal_code',
                'address',
                'phone',
            ]);
        });
    }
};
