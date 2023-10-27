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
        Schema::table('kardexes', function (Blueprint $table) {
            $table->unsignedInteger('physical_inventory_id')->nullable()->after('transaction_id');
            $table->foreign('physical_inventory_id')->references('id')->on('physical_inventories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('kardexes', function (Blueprint $table) {
            $table->dropForeign(['physical_inventory_id']);
            $table->dropColumn('physical_inventory_id');
        });
    }
};
