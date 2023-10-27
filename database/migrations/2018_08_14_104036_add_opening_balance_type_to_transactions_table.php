<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('purchase','sell', 'expense', 'stock_adjustment', 'sell_transfer', 'purchase_transfer', 
            'opening_stock', 'sell_return', 'opening_balance')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
