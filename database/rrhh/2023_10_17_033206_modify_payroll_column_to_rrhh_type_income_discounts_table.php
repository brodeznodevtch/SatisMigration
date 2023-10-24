<?php

use Illuminate\Database\Migrations\Migration;

class ModifyPayrollColumnToRrhhTypeIncomeDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE rrhh_type_income_discounts MODIFY COLUMN payroll_column VARCHAR(191) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
