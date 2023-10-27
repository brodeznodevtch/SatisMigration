<?php

use App\Models\Business;
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
        Schema::table('business', function (Blueprint $table) {
            $table->text('product_settings')->after('customer_settings')->nullable();
        });

        $default = [
            'show_stock_without_decimals' => 0,
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
        Schema::table('business', function (Blueprint $table) {
            $table->dropColumn('product_settings');
        });
    }
};
