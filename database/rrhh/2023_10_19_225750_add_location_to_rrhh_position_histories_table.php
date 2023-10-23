<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationToRrhhPositionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_type_income_discounts', function (Blueprint $table) {
            $table->string('concept')->nullable();
            $table->integer('catalogue_id')->unsigned()->nullable();
            $table->foreign('catalogue_id')->references('id')->on('catalogues')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('business_location_id')->unsigned()->nullable()->after('business_id');
            $table->foreign('business_location_id')->references('id')->on('business_locations')->onDelete('cascade')->onUpdate('cascade');
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
            $table->dropColumn('concept');
            $table->dropForeign(['catalogue_id']);
            $table->dropColumn('catalogue_id');
            $table->dropForeign(['business_location_id']);
            $table->dropColumn('business_location_id');
        });
    }
}
