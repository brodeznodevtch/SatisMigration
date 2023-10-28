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
        Schema::table('claims', function (Blueprint $table) {
            $table->unsignedInteger('status_claim_id')->nullable()->after('claim_type');
            $table->foreign('status_claim_id')->references('id')->on('status_claims')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('equipment_reception')->default(0)->after('invoice');
            $table->text('equipment_reception_desc')->nullable()->after('equipment_reception');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            //
        });
    }
};
