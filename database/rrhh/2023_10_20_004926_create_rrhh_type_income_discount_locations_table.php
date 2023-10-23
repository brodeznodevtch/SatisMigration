<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRrhhTypeIncomeDiscountLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhh_type_income_discount_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('catalogue_id')->unsigned()->nullable();
            $table->foreign('catalogue_id')->references('id')->on('catalogues')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('business_location_id')->unsigned()->nullable();
            $table->foreign('business_location_id')->references('id')->on('business_locations')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('rrhh_type_income_discount_id')->unsigned()->nullable();
            $table->foreign('rrhh_type_income_discount_id', 'rrhh_tind_tidl_id_foreign')->references('id')->on('rrhh_type_income_discounts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_type_income_discount_locations');
    }
}
