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
        Schema::table('contacts', function (Blueprint $table) {
            $table->boolean('is_supplier')
                ->nullable()
                ->after('type')
                ->default(false);
            $table->boolean('is_provider')
                ->nullable()
                ->after('is_supplier')
                ->default(false);
            $table->unsignedBigInteger('supplier_catalogue_id')
                ->after('tax_number')
                ->nullable();
            $table->unsignedBigInteger('provider_catalogue_id')
                ->after('supplier_catalogue_id')
                ->nullable();

            /** Relationship */
            $table->foreign('supplier_catalogue_id')
                ->references('id')
                ->on('catalogues');
            $table->foreign('provider_catalogue_id')
                ->references('id')
                ->on('catalogues');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('is_supplier');
            $table->dropColumn('is_provider');
        });
    }
};
