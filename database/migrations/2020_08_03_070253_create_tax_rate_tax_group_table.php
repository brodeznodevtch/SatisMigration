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
        Schema::create('tax_rate_tax_group', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tax_rate_id');
            //$table->foreign('tax_rates_id')->references('id')->on('tax_rates')->onDelete('cascade');
            $table->unsignedInteger('tax_group_id');
            //$table->foreign('tax_groups_id')->references('id')->on('tax_groups')->onDelete('cascade');
            //$table->softDeletes();
            //$table->timestamps();
        });

        Schema::table('tax_rate_tax_group', function (Blueprint $table) {
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates')->onDelete('cascade');
            $table->foreign('tax_group_id')->references('id')->on('tax_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_rate_tax_groups');
    }
};
