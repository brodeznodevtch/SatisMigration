<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status_lab_order_steps', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('status_id');
            $table->foreign('status_id')->references('id')->on('status_lab_orders')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('step_id');
            $table->foreign('step_id')->references('id')->on('status_lab_orders')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_lab_order_steps');
    }
};
