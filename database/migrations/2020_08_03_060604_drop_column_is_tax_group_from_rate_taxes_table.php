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
        Schema::table('tax_rates', function (Blueprint $table) {
            $table->dropColumn('is_tax_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {
            $table->smallInteger('is_tax_group')
                ->default(0);
        });
    }
};
