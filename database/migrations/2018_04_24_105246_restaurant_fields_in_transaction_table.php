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
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('res_table_id')->unsigned()->nullable()->after('location_id')->comment('fields to restaurant module');
            $table->integer('res_waiter_id')->unsigned()->nullable()->after('res_table_id')->comment('fields to restaurant module');
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
