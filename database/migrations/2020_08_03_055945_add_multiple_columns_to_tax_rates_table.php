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
        Schema::table('tax_rates', function (Blueprint $table) {
            $table->enum('type', ['purchase', 'sell'])->nullable()->default(null)->after('percent');
            $table->double('min_amount', 8.2)->nullable()->default(null)->after('type');
            $table->double('max_amount', 8.2)->nullable()->default(null)->after('min');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {
            //
        });
    }
};
