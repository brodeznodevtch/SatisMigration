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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payroll_type_id')->unsigned();
            $table->foreign('payroll_type_id')->references('id')->on('payroll_types')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->integer('year');
            $table->integer('month')->nullable();
            $table->integer('days')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date');
            $table->date('approval_date')->nullable();
            $table->date('pay_date')->nullable();

            $table->integer('payroll_status_id')->unsigned();
            $table->foreign('payroll_status_id')->references('id')->on('payroll_statuses')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('isr_id')->unsigned()->nullable();
            $table->foreign('isr_id')->references('id')->on('payment_periods')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('payment_period_id')->unsigned()->nullable();
            $table->foreign('payment_period_id')->references('id')->on('payment_periods')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('business_id')->unsigned()->nullable();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
};
