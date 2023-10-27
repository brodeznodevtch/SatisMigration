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
        Schema::table('purchase_lines', function (Blueprint $table) {
            DB::statement("ALTER TABLE `purchase_lines` 
                CHANGE `pp_without_discount` `pp_without_discount` 
                    DECIMAL(20,4) NOT NULL DEFAULT '0.0000' 
                        COMMENT 'Purchase price before inline discounts'");
            DB::statement("ALTER TABLE `purchase_lines` 
                CHANGE `discount_percent` `discount_percent` 
                    DECIMAL(8,4) NOT NULL DEFAULT '0.0000' 
                        COMMENT 'Inline discount percentage'");
            DB::statement('ALTER TABLE `purchase_lines` 
                CHANGE `purchase_price` `purchase_price` 
                    DECIMAL(20,4) NULL DEFAULT NULL');
            DB::statement("ALTER TABLE `purchase_lines` 
                CHANGE `purchase_price_inc_tax` `purchase_price_inc_tax` 
                    DECIMAL(20,4) NOT NULL DEFAULT '0.0000'");
            DB::statement('ALTER TABLE `purchase_lines` 
                CHANGE `item_tax` `item_tax` 
                    DECIMAL(20,4) NULL DEFAULT NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_lines', function (Blueprint $table) {
            //
        });
    }
};
