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
            $table->boolean('save_and_print')->default(0)->after('material_download');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_lab_orders', function (Blueprint $table) {
            $table->dropColumn('save_and_print');
        });
    }
};
