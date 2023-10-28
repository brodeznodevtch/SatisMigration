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
        Schema::create('apportionment_has_transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('apportionment_id');
            $table->foreign('apportionment_id')->references('id')->on('apportionments')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apportionment_has_transactions');
    }
};
