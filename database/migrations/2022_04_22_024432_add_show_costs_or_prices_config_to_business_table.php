<?php

use App\Models\Business;
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
        $business = Business::get();

        foreach ($business as $item) {
            $product_settings = json_decode($item->product_settings, true);

            $default = [
                'show_stock_without_decimals' => isset($product_settings['show_stock_without_decimals']) ? $product_settings['show_stock_without_decimals'] : 0,
                'decimals_in_sales' => isset($product_settings['decimals_in_sales']) ? $product_settings['decimals_in_sales'] : 4,
                'decimals_in_purchases' => isset($product_settings['decimals_in_purchases']) ? $product_settings['decimals_in_purchases'] : 4,
                'decimals_in_inventories' => isset($product_settings['decimals_in_inventories']) ? $product_settings['decimals_in_inventories'] : 4,
                'decimals_in_fiscal_documents' => isset($product_settings['decimals_in_fiscal_documents']) ? $product_settings['decimals_in_fiscal_documents'] : 2,
                'product_rotation' => isset($product_settings['product_rotation']) ? $product_settings['product_rotation'] : null,
                'show_costs_or_prices' => 'costs',
            ];

            $item->product_settings = json_encode($default);
            $item->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business', function (Blueprint $table) {
            //
        });
    }
};
