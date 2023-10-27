<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE rrhh_contracts MODIFY COLUMN contract_end_date DATE NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE rrhh_contracts MODIFY COLUMN contract_end_date DATE NULL');
    }
};
