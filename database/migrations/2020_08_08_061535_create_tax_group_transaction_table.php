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
        Schema::create('tax_group_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tax_group_id');
            $table->unsignedInteger('transaction_id');

            $table->timestamps();
        });

        Schema::table('tax_group_transaction', function (Blueprint $table) {
            $table->foreign('tax_group_id')->references('id')->on('tax_groups')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_group_transaction');
    }
};
