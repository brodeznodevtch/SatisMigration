<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN unit_cost_inputs DECIMAL(20, 6) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN total_cost_inputs DECIMAL(20, 6) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN unit_cost_outputs DECIMAL(20, 6) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN total_cost_outputs DECIMAL(20, 6) NOT NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN unit_cost_inputs DECIMAL(8, 2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN total_cost_inputs DECIMAL(8, 2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN unit_cost_outputs DECIMAL(8, 2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN total_cost_outputs DECIMAL(8, 2) NOT NULL DEFAULT 0');
    }
};
