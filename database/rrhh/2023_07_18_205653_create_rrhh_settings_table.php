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
        Schema::create('rrhh_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('automatic_closing');
            $table->time('exit_time')->nullable();
            $table->decimal('exempt_bonus', 10, 2)->nullable();
            $table->decimal('vacation_percentage', 10, 2)->nullable();
            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rrhh_settings');
    }
};
