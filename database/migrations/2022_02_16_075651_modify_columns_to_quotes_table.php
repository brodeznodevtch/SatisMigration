<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE quotes MODIFY COLUMN discount_amount DECIMAL(20, 6) NULL DEFAULT 0');
        DB::statement('ALTER TABLE quotes MODIFY COLUMN total_before_tax DECIMAL(20, 6) NOT NULL');
        DB::statement('ALTER TABLE quotes MODIFY COLUMN tax_amount DECIMAL(20, 6) NULL DEFAULT 0');
        DB::statement('ALTER TABLE quotes MODIFY COLUMN total_final DECIMAL(20, 6) NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE quotes MODIFY COLUMN discount_amount DECIMAL(10, 4) NULL DEFAULT 0');
        DB::statement('ALTER TABLE quotes MODIFY COLUMN total_before_tax DECIMAL(10, 4) NOT NULL');
        DB::statement('ALTER TABLE quotes MODIFY COLUMN tax_amount DECIMAL(10, 4) NULL DEFAULT 0');
        DB::statement('ALTER TABLE quotes MODIFY COLUMN total_final DECIMAL(10, 4) NOT NULL');
    }
};
