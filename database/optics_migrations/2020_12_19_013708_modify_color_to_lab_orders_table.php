<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('lab_orders', function (Blueprint $table) {
            $table->dropForeign(['color']);
        });

        Schema::table('lab_orders', function (Blueprint $table) {
            DB::statement('ALTER TABLE lab_orders MODIFY COLUMN color VARCHAR(191) NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
