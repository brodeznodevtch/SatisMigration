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
        Schema::table('pos', function (Blueprint $table) {
            $table->unsignedInteger('employee_id')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pos', function (Blueprint $table) {
            //
        });
    }
};
