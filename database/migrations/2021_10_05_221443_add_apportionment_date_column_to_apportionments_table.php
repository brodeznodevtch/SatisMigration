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
        Schema::table('apportionments', function (Blueprint $table) {
            $table->date('apportionment_date')->nullable()->after('business_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apportionments', function (Blueprint $table) {
            $table->dropColumn('apportionment_date');
        });
    }
};
