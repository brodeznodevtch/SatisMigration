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
    public function up()
    {
        DB::statement('ALTER TABLE rrhh_income_discounts MODIFY COLUMN quotas_applied DECIMAL(10, 2) NOT NULL DEFAULT 0');
        Schema::table('rrhh_income_discounts', function (Blueprint $table) {
            $table->boolean('is_paid')->nullable()->default(0)->after('balance_to_date');
        });
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
};
