<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE rrhh_contracts MODIFY COLUMN contract_end_date DATE NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE rrhh_contracts MODIFY COLUMN contract_end_date DATE NULL');
    }
};
