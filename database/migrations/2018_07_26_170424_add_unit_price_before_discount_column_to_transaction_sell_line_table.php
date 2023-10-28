<?php

use App\Models\TransactionSellLine;
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
        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            $table->decimal('unit_price_before_discount', 20, 2)->after('quantity')->default(0);
        });

        //Set all unit_price_before_discount value same as unit_price value
        $sell_lines = TransactionSellLine::get();
        foreach ($sell_lines as $sell_line) {
            $sell_line->unit_price_before_discount = $sell_line->unit_price;
            $sell_line->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            //
        });
    }
};
