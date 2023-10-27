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
        DB::statement('ALTER TABLE purchase_lines MODIFY COLUMN quantity DECIMAL(20, 4) NOT NULL');
        DB::statement('ALTER TABLE purchase_lines MODIFY COLUMN quantity_sold DECIMAL(20, 4) DEFAULT 0.00');
        DB::statement('ALTER TABLE purchase_lines MODIFY COLUMN quantity_adjusted DECIMAL(20, 4) DEFAULT 0.00');

        DB::statement('ALTER TABLE stock_adjustment_lines MODIFY COLUMN quantity DECIMAL(20, 4) NOT NULL');

        DB::statement('ALTER TABLE transaction_sell_lines MODIFY COLUMN quantity DECIMAL(20, 4) NOT NULL');

        DB::statement('ALTER TABLE transaction_sell_lines_purchase_lines MODIFY COLUMN quantity DECIMAL(20, 4) NOT NULL');
        DB::statement('ALTER TABLE variation_location_details MODIFY COLUMN qty_available DECIMAL(20, 4) NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
