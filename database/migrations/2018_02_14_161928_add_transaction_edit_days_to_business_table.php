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
        Schema::table('business', function (Blueprint $table) {
            $table->integer('transaction_edit_days')->unsigned()->after('p_exchange_rate')->default(30);
            $table->integer('stock_expiry_alert_days')->unsigned()->after('transaction_edit_days')->default(30);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business', function (Blueprint $table) {
            $table->dropColumn('transaction_edit_days');
        });
    }
};
