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
        Schema::table('status_lab_orders', function (Blueprint $table) {
            $table->boolean('material_download')->default(0)->after('second_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_lab_orders', function (Blueprint $table) {
            $table->dropColumn('material_download');
        });
    }
};
