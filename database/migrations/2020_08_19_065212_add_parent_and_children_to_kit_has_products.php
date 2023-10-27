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
        Schema::table('kit_has_products', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->after('id');
            $table->unsignedInteger('children_id')->after('parent_id');
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('children_id')->references('id')->on('variations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('kit_has_products', function (Blueprint $table) {
            //
        });
    }
};
