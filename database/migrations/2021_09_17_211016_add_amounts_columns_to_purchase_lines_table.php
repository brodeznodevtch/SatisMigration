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
            $table->decimal('initial_purchase_price', 20, 4)->nullable()->after('lot_number');
            $table->decimal('import_expense_amount', 20, 4)->nullable()->after('initial_purchase_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_lines', function (Blueprint $table) {
            $table->dropColumn('initial_purchase_price');
            $table->dropColumn('import_expense_amount');
        });
    }
};
