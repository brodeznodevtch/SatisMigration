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
        Schema::create('cost_center_operation_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cost_center_id');
            $table->unsignedBigInteger('sell_expense_account')
                ->nullable()
                ->comment('Selling expense account id')
                ->default(null);
            $table->unsignedBigInteger('admin_expense_account')
                ->nullable()
                ->comment('Administration expense account id')
                ->default(null);
            $table->unsignedBigInteger('finantial_expense_account')
                ->nullable()
                ->comment('Finantial expense account id')
                ->default(null);
            $table->unsignedBigInteger('non_dedu_expense_account')
                ->nullable()
                ->comment('non-deductible expense account id')
                ->default(null);
            $table->unsignedInteger('updated_by')
                ->nullable()
                ->default(null);
            $table->timestamps();

            $table->foreign('cost_center_id')
                ->on('cost_centers')
                ->references('id');
            $table->foreign('sell_expense_account')
                ->on('catalogues')
                ->references('id');
            $table->foreign('admin_expense_account')
                ->on('catalogues')
                ->references('id');
            $table->foreign('finantial_expense_account')
                ->on('catalogues')
                ->references('id');
            $table->foreign('non_dedu_expense_account')
                ->on('catalogues')
                ->references('id');
            $table->foreign('updated_by')
                ->on('users')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_center_operation_accounts');
    }
};
