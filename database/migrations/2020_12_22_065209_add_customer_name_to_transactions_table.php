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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedInteger('customer_id')
                ->nullable()
                ->default(null)
                ->after('contact_id');
            $table->string('customer_name')
                ->nullable()
                ->default(null)
                ->after('customer_id');

            $table->foreign('customer_id')
                ->on('customers')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('customer_id');
            $table->dropColumn('customer_id');
            $table->dropColumn('customer_name');
        });
    }
};
