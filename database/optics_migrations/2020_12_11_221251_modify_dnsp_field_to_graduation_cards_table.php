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
        Schema::table('graduation_cards', function (Blueprint $table) {
            DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN dnsp_os VARCHAR(191)');
            DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN dnsp_od VARCHAR(191)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
