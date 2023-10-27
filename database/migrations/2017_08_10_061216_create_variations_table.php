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
        Schema::create('variations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('sub_sku')->nullable();
            $table->integer('product_variation_id')->unsigned();
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
            $table->decimal('default_purchase_price', 8, 2)->nullable();
            $table->decimal('dpp_inc_tax', 8, 2)->default(0);
            $table->decimal('profit_percent', 8, 2)->default(0);
            $table->decimal('default_sell_price', 8, 2)->nullable();
            $table->decimal('sell_price_inc_tax', 8, 2)->comment('Sell price including tax')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //Indexing
            $table->index('name');
            $table->index('sub_sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variations');
    }
};
