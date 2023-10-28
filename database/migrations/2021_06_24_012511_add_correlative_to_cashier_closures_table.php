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
        Schema::table('cashier_closures', function (Blueprint $table) {
            $table->string('correlative')
                ->after('total_return_amount')
                ->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cashier_closures', function (Blueprint $table) {
            $table->dropColumn('correlative');
        });
    }
};
