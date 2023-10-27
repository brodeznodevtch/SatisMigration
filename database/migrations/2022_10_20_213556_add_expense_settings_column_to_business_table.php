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
            $table->text('expense_settings')->after('product_settings')->nullable();
        });

        $default = [
            'hide_location_column' => 0,
        ];

        $business = Business::get();

        foreach ($business as $item) {
            $item->expense_settings = json_encode($default);
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
            $table->dropColumn('expense_settings');
        });
    }
};
