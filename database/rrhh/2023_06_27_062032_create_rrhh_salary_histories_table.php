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
    public function up(): void
    {
        Schema::create('rrhh_salary_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('salary', 10, 2);
            $table->boolean('current')->default(false);
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('rrhh_personnel_action_id')->unsigned()->nullable();
            $table->foreign('rrhh_personnel_action_id', 'rrhh_pa_id_foreign')->references('id')->on('rrhh_personnel_actions')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('rrhh_salary_histories');
    }
};
