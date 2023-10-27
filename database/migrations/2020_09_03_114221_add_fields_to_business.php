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
            $table->boolean('enable_sub_accounts_in_bank_transactions')->default(1)->after('business_full_name');

            $table->unsignedBigInteger('accounting_supplier_id')->after('enable_sub_accounts_in_bank_transactions')->nullable();
            $table->unsignedBigInteger('accounting_customer_id')->after('accounting_supplier_id')->nullable();

            $table->foreign('accounting_supplier_id')->references('id')->on('catalogues');
            $table->foreign('accounting_customer_id')->references('id')->on('catalogues');
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
