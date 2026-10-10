<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('payment_proof');
            $table->string('payment_type')->nullable()->after('snap_token');
            $table->string('payment_bank')->nullable()->after('payment_type');
            $table->string('va_number')->nullable()->after('payment_bank');
            $table->text('payment_qr_url')->nullable()->after('va_number');
            $table->string('payment_code')->nullable()->after('payment_qr_url');
            $table->text('payment_deeplink_url')->nullable()->after('payment_code');
            $table->timestamp('payment_expired_at')->nullable()->after('payment_deeplink_url');
            $table->timestamp('paid_at')->nullable()->after('payment_expired_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'snap_token',
                'payment_type',
                'payment_bank',
                'va_number',
                'payment_qr_url',
                'payment_code',
                'payment_deeplink_url',
                'payment_expired_at',
                'paid_at',
            ]);
        });
    }
};
