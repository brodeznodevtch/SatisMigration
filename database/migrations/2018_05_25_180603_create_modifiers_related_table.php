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
        Schema::create('res_product_modifier_sets', function (Blueprint $table) {
            $table->integer('modifier_set_id')->unsigned();
            $table->foreign('modifier_set_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->comment('Table use to store the modifier sets applicable for a product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('res_product_modifier_sets');
        Schema::dropIfExists('res_product_modifier_sets');
    }
};
