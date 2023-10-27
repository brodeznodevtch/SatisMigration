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
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->dropColumn('closing_amount');
            $table->dropColumn('total_card_slips');
            $table->dropColumn('total_cheques');

            $table->decimal('total_amount_cash', 10, 4)
                ->after('status')
                ->default(0.0000);
            $table->decimal('total_amount_card', 10, 4)
                ->after('total_amount_cash')
                ->default(0.0000);
            $table->decimal('total_amount_check', 10, 4)
                ->after('total_amount_card')
                ->default(0.0000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->decimal('closing_amount', 8, 2)
                ->default(0);
            $table->integer('total_card_slips')
                ->default(0);
            $table->integer('total_cheques')
                ->default(0);
        });
    }
};
