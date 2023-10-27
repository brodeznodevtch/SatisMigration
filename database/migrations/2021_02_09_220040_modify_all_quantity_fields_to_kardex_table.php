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
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN inputs_quantity DECIMAL(20, 4) DEFAULT 0');
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN outputs_quantity DECIMAL(20, 4) DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN inputs_quantity DECIMAL(8, 2) DEFAULT 0');
        DB::statement('ALTER TABLE kardexes MODIFY COLUMN outputs_quantity DECIMAL(8, 2) DEFAULT 0');
    }
};
