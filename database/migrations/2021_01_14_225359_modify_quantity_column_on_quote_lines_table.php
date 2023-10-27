<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE `quote_lines` CHANGE `quantity` `quantity` DECIMAL(8,2) NOT NULL');
        Schema::table('quote_lines', function (Blueprint $table) {
            //$table->decimal("quantity", 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_lines', function (Blueprint $table) {
            //
        });
    }
};
