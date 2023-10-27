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
        DB::statement('ALTER TABLE `variation_group_prices` CHANGE `price_inc_tax` `price_inc_tax` DECIMAL(20,4) NOT NULL;');
        Schema::table('variation_group_prices', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('variation_group_prices', function (Blueprint $table) {
            //
        });
    }
};
