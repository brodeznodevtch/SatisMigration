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
        Schema::table('kardexes', function (Blueprint $table) {
            $table->decimal('balance', 20, 4)->default(0)->after('total_cost_outputs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('kardexes', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
};
