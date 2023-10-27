<?php

use App\Models\Business;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $default = [
            'show_stock_without_decimals' => 0,
            'decimals_in_sales' => 4,
            'decimals_in_purchases' => 4,
            'decimals_in_inventories' => 4,
            'decimals_in_fiscal_documents' => 2,
        ];

        $business = Business::get();

        foreach ($business as $item) {
            $item->product_settings = json_encode($default);
            $item->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $default = [
            'show_stock_without_decimals' => 0,
        ];

        $business = Business::get();

        foreach ($business as $item) {
            $item->product_settings = json_encode($default);
            $item->save();
        }
    }
};
