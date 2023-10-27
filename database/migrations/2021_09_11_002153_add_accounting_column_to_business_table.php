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
        Schema::table('business', function (Blueprint $table) {
            $table->unsignedBigInteger('accounting_vat_local_purchase_id')
                ->after('accounting_inventory_id')
                ->nullable()
                ->default(null);
            $table->unsignedBigInteger('accounting_vat_import_id')
                ->after('accounting_vat_local_purchase_id')
                ->nullable()
                ->default(null);
            $table->unsignedBigInteger('accounting_perception_id')
                ->after('accounting_vat_import_id')
                ->nullable()
                ->default(null);

            $table->foreign('accounting_vat_local_purchase_id')
                ->references('id')
                ->on('catalogues');
            $table->foreign('accounting_vat_import_id')
                ->references('id')
                ->on('catalogues');
            $table->foreign('accounting_perception_id')
                ->references('id')
                ->on('catalogues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('business', function (Blueprint $table) {
            //
        });
    }
};
