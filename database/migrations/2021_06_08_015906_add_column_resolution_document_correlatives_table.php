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
        Schema::table('document_correlatives', function (Blueprint $table) {
            $table->string('resolution')->nullable()->after('serie');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('document_correlatives', function (Blueprint $table) {
            $table->dropColumn('resolution');
        });
    }
};
