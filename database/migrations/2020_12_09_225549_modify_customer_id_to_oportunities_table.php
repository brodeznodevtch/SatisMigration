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
        Schema::table('oportunities', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['new_customer_id']);
        });

        Schema::table('oportunities', function (Blueprint $table) {
            $table->dropColumn('customer_id');
            $table->dropColumn('new_customer_id');
        });

        Schema::table('oportunities', function (Blueprint $table) {
            $table->unsignedInteger('customer_id')->nullable()->after('products_not_found_desc');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
