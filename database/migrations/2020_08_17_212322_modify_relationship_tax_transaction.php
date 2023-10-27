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
            $table->dropIndex('transactions_tax_id_foreign');

            $table->foreign('tax_id')
                ->references('id')
                ->on('tax_groups')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['tax_id']);

            $table->foreign('tax_id')
                ->references('id')
                ->on('tax_rates')
                ->onDelete('cascade');
        });
    }
};
