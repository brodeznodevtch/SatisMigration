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
        Schema::table('lab_orders', function (Blueprint $table) {
            $table->unsignedInteger('contact_id')
                ->nullable()
                ->after('customer_id');

            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lab_orders', function (Blueprint $table) {
            $table->dropForeign('contact_id');
            $table->dropColumn('contact_id');
        });
    }
};
