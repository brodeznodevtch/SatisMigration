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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id', 10);
            $table->string('name');
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->date('hireddate')->nullable();
            $table->date('fireddate')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('agentcode')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
