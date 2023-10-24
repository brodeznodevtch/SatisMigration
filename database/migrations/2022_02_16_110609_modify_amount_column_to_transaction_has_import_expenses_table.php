<?php

use Illuminate\Database\Migrations\Migration;

class ModifyAmountColumnToTransactionHasImportExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE transaction_has_import_expenses MODIFY COLUMN amount DECIMAL(20, 6) NOT NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE transaction_has_import_expenses MODIFY COLUMN amount DECIMAL(20, 4) NOT NULL DEFAULT 0');
    }
}
