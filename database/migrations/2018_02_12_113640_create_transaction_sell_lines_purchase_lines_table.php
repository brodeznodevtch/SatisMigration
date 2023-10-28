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
        Schema::create('transaction_sell_lines_purchase_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sell_line_id')->unsigned()->comment('id from transaction_sell_lines')->nullable();
            $table->integer('stock_adjustment_line_id')->unsigned()->comment('id from stock_adjustment_lines')->nullable();
            $table->integer('purchase_line_id')->unsigned()->comment('id from purchase_lines');
            $table->decimal('quantity', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_sell_lines_purchase_lines');
    }
};
