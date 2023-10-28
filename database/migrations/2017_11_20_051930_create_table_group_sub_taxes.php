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
        Schema::create('group_sub_taxes', function (Blueprint $table) {
            $table->integer('group_tax_id')->unsigned();
            $table->foreign('group_tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
            $table->integer('tax_id')->unsigned();
            $table->foreign('tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
