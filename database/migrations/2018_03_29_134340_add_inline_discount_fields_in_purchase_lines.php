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
        Schema::table('purchase_lines', function (Blueprint $table) {
            $table->decimal('pp_without_discount', 20, 2)->after('quantity')->default(0)->comment('Purchase price before inline discounts');
            $table->decimal('discount_percent', 5, 2)->after('pp_without_discount')->default(0)->comment('Inline discount percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('purchase_lines', function (Blueprint $table) {
            //
        });
    }
};
