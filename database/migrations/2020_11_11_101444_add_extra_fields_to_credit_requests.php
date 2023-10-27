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
        Schema::table('credit_requests', function (Blueprint $table) {
            $table->string('correlative')->nullable()->after('id');
            $table->string('file')->nullable()->after('date_request');
            $table->string('observations')->nullable()->after('file');
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending')->after('observations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_requests', function (Blueprint $table) {
            //
        });
    }
};
