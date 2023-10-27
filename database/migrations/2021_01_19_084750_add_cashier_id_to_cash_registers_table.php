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
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->unsignedInteger('cashier_id')
                ->nullable()
                ->default(null)
                ->after('user_id');
            $table->foreign('cashier_id')
                ->references('id')
                ->on('cashiers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('cash_registers', function (Blueprint $table) {
            //
        });
    }
};
