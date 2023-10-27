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
        Schema::table('rrhh_datas', function (Blueprint $table) {
            $table->boolean('number_required')->nullable()->after('date_required');
            $table->boolean('expedition_place')->nullable()->after('number_required');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_datas', function (Blueprint $table) {
            $table->dropColumn('number_required');
        });
    }
};
