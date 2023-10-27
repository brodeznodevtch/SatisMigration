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
        Schema::create('status_claims', function (Blueprint $table) {
            $table->increments('id');
            $table->string('correlative');
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->integer('predecessor')->nullable();
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
        Schema::dropIfExists('status_claims');
    }
};
