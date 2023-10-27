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
    public function up()
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('bank_account_id');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');

            $table->unsignedBigInteger('accounting_entrie_id');
            $table->foreign('accounting_entrie_id')->references('id')->on('accounting_entries')->onDelete('cascade');

            $table->enum('type', ['consignment', 'check', 'send_transfer', 'receive_transfer']);
            $table->string('reference');
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->string('description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_transactions');
    }
};
