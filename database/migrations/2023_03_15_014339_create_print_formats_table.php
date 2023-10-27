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
        Schema::create('print_formats', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('business_id');
            $table->unsignedInteger('location_id');
            $table->Integer('document_type_id');
            $table->string('format', 64);

            $table->foreign('business_id')
                ->on('business')
                ->references('id');
            $table->foreign('location_id')
                ->on('business_locations')
                ->references('id');
            $table->foreign('document_type_id')
                ->on('document_types')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('print_formats');
    }
};
