<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false)->after('role');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->decimal('payout_amount', 10, 2)->after('amount_aed');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_banned');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn('payout_amount');
        });
    }
};
