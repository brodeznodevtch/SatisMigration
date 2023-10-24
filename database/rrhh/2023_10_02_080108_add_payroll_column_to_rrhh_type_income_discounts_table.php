<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayrollColumnToRrhhTypeIncomeDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_type_income_discounts', function (Blueprint $table) {
            $table->boolean('payroll_column')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_type_income_discounts', function (Blueprint $table) {
            $table->dropColumn('payroll_column');
        });
    }
}
