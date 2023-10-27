<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->integer('bank_transaction_id', false, true)
                ->nullable()
                ->default(null)
                ->after('account_id');

            $table->foreign('bank_transaction_id')
                ->references('id')
                ->on('bank_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            //
        });
    }
};
