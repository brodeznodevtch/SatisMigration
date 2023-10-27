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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('unit_id')->nullable()->after('type');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            $table->unsignedInteger('unit_group_id')->nullable()->after('unit_id');
            $table->foreign('unit_group_id')->references('id')->on('unit_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
