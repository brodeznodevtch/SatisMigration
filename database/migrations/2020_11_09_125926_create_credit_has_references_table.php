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
        Schema::create('credit_has_references', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('credit_id')->nullable();
            $table->foreign('credit_id')->references('id')->on('credit_requests')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('phone');
            $table->decimal('amount', 10, 2);
            $table->date('date_cancelled');
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
        Schema::dropIfExists('credit_has_references');
    }
};
