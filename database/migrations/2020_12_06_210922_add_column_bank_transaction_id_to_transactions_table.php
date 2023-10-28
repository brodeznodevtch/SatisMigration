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
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('bank_transaction_id', false, true)
                ->nullable()
                ->default(null)
                ->after('location_id');

            $table->foreign('bank_transaction_id')
                ->references('id')
                ->on('bank_transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['bank_transaction_id']);
            $table->dropColumn('bank_transaction_id');
        });
    }
};
