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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('delivered_by')->nullable()->after('cash_register_id');
            $table->string('delivered_by_dui')->nullable()->after('delivered_by');
            $table->string('delivered_by_passport')->nullable()->after('delivered_by_dui');

            $table->string('received_by')->nullable()->after('delivered_by_passport');
            $table->string('received_by_dui')->nullable()->after('received_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('delivered_by');
            $table->dropColumn('delivered_by_dui');
            $table->dropColumn('delivered_by_passport');

            $table->dropColumn('received_by');
            $table->dropColumn('received_by_dui');
        });
    }
};
