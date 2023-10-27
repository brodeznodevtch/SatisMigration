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
        Schema::table('variation_location_details', function (Blueprint $table) {
            $table->decimal('qty_reserved', 20, 4)->nullable()->default(0)->after('qty_available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variation_location_details', function (Blueprint $table) {
            $table->dropColumn('qty_reserved');
        });
    }
};
