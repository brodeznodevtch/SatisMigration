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
        DB::statement('ALTER TABLE transaction_payments MODIFY COLUMN transaction_id INT(11) UNSIGNED DEFAULT NULL');

        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->integer('payment_for')->after('created_by')->nullable();
            $table->integer('parent_id')->after('payment_for')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            //
        });
    }
};
