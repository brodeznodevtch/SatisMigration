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
        Schema::create('document_correlatives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serie')->nullable();
            $table->integer('initial')->default('0');
            $table->integer('actual')->default('0');
            $table->integer('final')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_correlatives');
    }
};
