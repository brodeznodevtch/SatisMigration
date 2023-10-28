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
        Schema::table('product_has_suppliers', function (Blueprint $table) {
            $table->string('catalogue')->after('contact_id');
            $table->integer('uxc')->after('catalogue');
            $table->decimal('weight', 8, 2)->after('uxc');
            $table->decimal('dimensions', 8, 2)->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_has_suppliers', function (Blueprint $table) {
            //
        });
    }
};
