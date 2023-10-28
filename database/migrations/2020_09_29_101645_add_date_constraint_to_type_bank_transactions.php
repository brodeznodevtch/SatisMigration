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
        Schema::table('type_bank_transactions', function (Blueprint $table) {
            $table->boolean('enable_date_constraint')->default(0)->after('enable_headline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_bank_transactions', function (Blueprint $table) {
            //
        });
    }
};
