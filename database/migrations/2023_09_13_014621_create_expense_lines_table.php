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
        Schema::create('expense_lines', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('transaction_id');
            $table->unsignedInteger('expense_category_id');
            $table->decimal('line_total_exc_tax', 20, 6);

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions');
            $table->foreign('expense_category_id')
                ->references('id')
                ->on('expense_categories');

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
        Schema::dropIfExists('expense_lines');
    }
};
