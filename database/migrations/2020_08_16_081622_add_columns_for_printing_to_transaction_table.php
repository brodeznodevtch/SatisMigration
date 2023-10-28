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
            $table->string('operating_conditions')->after('document')->nullable();
            $table->string('authorized_by')->after('operating_conditions')->nullable();
            $table->string('order_number')->after('authorized_by')->nullable();
            $table->string('declaration_number')->after('order_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(
                [
                    'operating_conditions',
                    'authorized_by',
                    'order_number',
                    'declaration_number',
                ]
            );
        });
    }
};
