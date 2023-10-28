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
        Schema::table('kardexes', function (Blueprint $table) {
            $table->unsignedInteger('lab_order_id')->nullable()->after('transaction_id');
            $table->foreign('lab_order_id')->references('id')->on('lab_orders')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kardexes', function (Blueprint $table) {
            $table->dropForeign(['lab_order_id']);
            $table->dropColumn('lab_order_id');
        });
    }
};
