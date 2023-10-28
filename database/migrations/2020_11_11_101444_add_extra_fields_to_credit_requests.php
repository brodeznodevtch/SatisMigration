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
        Schema::table('credit_requests', function (Blueprint $table) {
            $table->string('correlative')->nullable()->after('id');
            $table->string('file')->nullable()->after('date_request');
            $table->string('observations')->nullable()->after('file');
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending')->after('observations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credit_requests', function (Blueprint $table) {
            //
        });
    }
};
