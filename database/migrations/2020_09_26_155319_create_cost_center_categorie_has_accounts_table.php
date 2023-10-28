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
        Schema::create('cost_center_categorie_has_accounts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('categorie_id');
            $table->foreign('categorie_id')->references('id')->on('cost_center_categories')->onDelete('cascade');

            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('catalogues')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_center_categorie_has_accounts');
    }
};
