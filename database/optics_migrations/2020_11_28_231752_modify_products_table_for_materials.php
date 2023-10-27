<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE products MODIFY COLUMN clasification ENUM('kits','product', 'service', 'material')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
