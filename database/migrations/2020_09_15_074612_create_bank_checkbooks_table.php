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
        Schema::create('bank_checkbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('serie');
            $table->integer('initial_correlative');
            $table->integer('final_correlative');
            $table->integer('last_correlative');

            $table->unsignedInteger('bank_account_id');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_checkbooks');
    }
};
