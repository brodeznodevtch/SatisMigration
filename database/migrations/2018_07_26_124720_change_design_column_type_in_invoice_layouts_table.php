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
        DB::statement("ALTER TABLE invoice_layouts MODIFY COLUMN design VARCHAR(256) DEFAULT 'classic'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
