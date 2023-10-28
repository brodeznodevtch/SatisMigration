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
            $table->dropForeign(['location_id']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['location_id']);
        });

        //Schema::table('transactions', function (Blueprint $table) {
        //$table->unsignedInteger('location_id')->nullable()->change();
        //$table->foreign('location_id')->references('id')->on('business_locations');
        //});
        DB::statement('ALTER TABLE transactions MODIFY COLUMN location_id INT(10) UNSIGNED NULL');
        DB::statement('ALTER TABLE transactions ADD CONSTRAINT transactions_location_id_foreign FOREIGN KEY (location_id) REFERENCES business_locations (id)');
        DB::statement('ALTER TABLE transactions ADD INDEX transactions_location_id_index (location_id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
