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
        Schema::table('customers', function (Blueprint $table) {
            $table->time('from')
                ->nullable()
                ->default(null)
                ->after('length');
            $table->time('to')
                ->nullable()
                ->default(null)
                ->after('from');
            $table->decimal('cost', 10, 2)
                ->nullable()
                ->default(null)
                ->after('to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('from');
            $table->dropColumn('to');
            $table->dropColumn('cost');
        });
    }
};
