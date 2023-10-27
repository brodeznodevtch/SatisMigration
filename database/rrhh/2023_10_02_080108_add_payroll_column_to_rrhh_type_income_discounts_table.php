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
        Schema::table('rrhh_type_income_discounts', function (Blueprint $table) {
            $table->boolean('payroll_column')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rrhh_type_income_discounts', function (Blueprint $table) {
            $table->dropColumn('payroll_column');
        });
    }
};
