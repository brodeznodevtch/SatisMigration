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
        Schema::table('graduation_cards', function (Blueprint $table) {
            $table->dropColumn('lens_color');
            $table->dropColumn('bif');
            $table->dropColumn('ring');
            $table->dropColumn('size');
            $table->dropColumn('color');
            DB::statement('ALTER TABLE graduation_cards MODIFY COLUMN di VARCHAR(191)');
            $table->boolean('is_prescription')->after('business_id')->default(0);
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
