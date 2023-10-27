<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE physical_inventory_lines MODIFY COLUMN price DECIMAL(20, 6) NOT NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE physical_inventory_lines MODIFY COLUMN price DECIMAL(20, 4) NOT NULL DEFAULT 0');
    }
};
