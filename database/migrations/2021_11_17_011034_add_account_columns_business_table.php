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
            $table->enum('debt_to_pay_type', ['supplier', 'bag_account', 'cost_center'])->after('accounting_customer_id')->nullable()->default(null);
            $table->enum('receivable_type', ['customer', 'bag_account', 'cost_center'])->after('accounting_customer_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business', function (Blueprint $table) {
            //
        });
    }
};
