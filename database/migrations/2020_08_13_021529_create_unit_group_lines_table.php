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
        Schema::create('unit_group_lines', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            $table->integer('unit_group_id')->unsigned();
            $table->foreign('unit_group_id')->references('id')->on('unit_groups')->onDelete('cascade');

            $table->decimal('factor', 10, 2);
            $table->boolean('default');

            $table->softDeletes();
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
        Schema::dropIfExists('unit_group_lines');
    }
};
