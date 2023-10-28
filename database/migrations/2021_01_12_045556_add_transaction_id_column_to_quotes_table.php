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
        Schema::table('quotes', function (Blueprint $table) {
            $table->integer('transaction_id')
                ->nullable()
                ->default(null)
                ->after('document_type_id')
                ->unsigned();

            $table->foreign('transaction_id')
                ->on('transactions')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign('transaction_id');
            $table->dropColumn('transaction_id');
        });
    }
};
