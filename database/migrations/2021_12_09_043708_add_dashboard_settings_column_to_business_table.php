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
        Schema::table('business', function (Blueprint $table) {
            $table->text('dashboard_settings')->after('sms_settings')->nullable();
        });

        $default = [
            'subtract_sell_return' => 0,
            'box_exc_tax' => 0,
        ];

        $business = Business::get();

        foreach ($business as $item) {
            $item->dashboard_settings = json_encode($default);
            $item->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business', function (Blueprint $table) {
            $table->dropColumn('dashboard_settings');
        });
    }
};
