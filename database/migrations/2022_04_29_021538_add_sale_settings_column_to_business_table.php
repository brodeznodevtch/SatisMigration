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
            $table->text('sale_settings')->after('product_settings')->nullable();
        });

        $default = [
            'no_note_full_payment' => 0,
        ];

        $business = Business::get();

        foreach ($business as $item) {
            $item->sale_settings = json_encode($default);
            $item->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business', function (Blueprint $table) {
            $table->dropColumn('sale_settings');
        });
    }
};
