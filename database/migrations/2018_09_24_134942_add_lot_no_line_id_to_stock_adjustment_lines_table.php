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
        Schema::table('stock_adjustment_lines', function (Blueprint $table) {
            $table->integer('lot_no_line_id')->nullable()->after('removed_purchase_line');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('stock_adjustment_lines', function (Blueprint $table) {
            //
        });
    }
};
