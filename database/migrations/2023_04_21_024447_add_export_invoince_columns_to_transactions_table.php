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
            $table->decimal('fob_amount', 10, 6)
                ->nullable()
                ->after('customs_procedure_amount')
                ->comment('FOB for export invoice');
            $table->decimal('insurance_amount', 10, 6)
                ->nullable()
                ->after('fob_amount')
                ->comment('Insurance fr export invoice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('fob_amount');
            $table->dropColumn('insurance_amount');
        });
    }
};
