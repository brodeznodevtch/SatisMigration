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
            $table->string('product_custom_field1')->nullable()->after('weight');
            $table->string('product_custom_field2')->nullable()->after('product_custom_field1');
            $table->string('product_custom_field3')->nullable()->after('product_custom_field2');
            $table->string('product_custom_field4')->nullable()->after('product_custom_field3');
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
            $table->dropColumn('product_custom_field1');
            $table->dropColumn('product_custom_field2');
            $table->dropColumn('product_custom_field3');
            $table->dropColumn('product_custom_field4');
        });
    }
};
