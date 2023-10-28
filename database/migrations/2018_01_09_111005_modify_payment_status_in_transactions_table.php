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
        DB::statement("ALTER TABLE transactions MODIFY COLUMN payment_status ENUM('paid', 'due', 'partial')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
