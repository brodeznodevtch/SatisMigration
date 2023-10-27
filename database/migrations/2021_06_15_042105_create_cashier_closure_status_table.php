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
        Schema::create('cashier_closure_status', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cashier_closure_id');
            $table->unsignedInteger('status_id')->nullable();
            $table->timestamps();

            $table->foreign('cashier_closure_id')->references('id')->on('cashier_closures');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashier_closure_status');
    }
};
