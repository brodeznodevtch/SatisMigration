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
        Schema::table('business', function (Blueprint $table) {
            $table->boolean('enable_editing_avg_cost_from_purchase')->default(0)->after('enable_editing_product_from_purchase');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('business', function (Blueprint $table) {
            $table->dropColumn('enable_editing_avg_cost_from_purchase');
        });
    }
};
