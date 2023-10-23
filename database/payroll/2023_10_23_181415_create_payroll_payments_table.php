<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('check_number')->nullable();
            $table->string('reference')->nullable();
            $table->integer('payroll_id')->unsigned()->nullable();
            $table->foreign('payroll_id')->references('id')->on('payrolls')->onDelete('cascade');
            $table->integer('payment_id')->unsigned()->nullable();
            $table->foreign('payment_id')->references('id')->on('rrhh_datas')->onDelete('cascade');
            $table->integer('bank_account_id')->nullable();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->integer('bank_checkbook_id')->nullable();
            $table->foreign('bank_checkbook_id')->references('id')->on('bank_checkbooks')->onDelete('cascade');
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
        Schema::dropIfExists('payroll_payments');
    }
}
