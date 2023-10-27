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
        Schema::table('apportionments', function (Blueprint $table) {
            $table->boolean('is_finished')->default(0)->after('vat_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('apportionments', function (Blueprint $table) {
            $table->dropColumn('is_finished');
        });
    }
};
