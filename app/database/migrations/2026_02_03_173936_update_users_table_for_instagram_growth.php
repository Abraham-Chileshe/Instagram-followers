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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('recruiter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('balance_aed', 10, 2)->default(0);
            $table->string('payment_preference')->default('cash'); // cash, usdt
            $table->string('usdt_wallet_address')->nullable();
            $table->boolean('is_subscribed_to_target')->default(false);
            $table->timestamp('joined_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['recruiter_id']);
            $table->dropColumn(['recruiter_id', 'balance_aed', 'payment_preference', 'usdt_wallet_address', 'is_subscribed_to_target', 'joined_at']);
        });
    }
};
