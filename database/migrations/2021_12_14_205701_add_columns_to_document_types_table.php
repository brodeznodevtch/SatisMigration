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
        Schema::table('document_types', function (Blueprint $table) {
            $table->unsignedInteger('document_class_id')->nullable();
            $table->foreign('document_class_id')->references('id')->on('document_classes');

            $table->string('document_type_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_types', function (Blueprint $table) {
            $table->dropForeign(['document_class_id']);
            $table->dropColumn('document_class_id');

            $table->dropColumn('document_type_number');
        });
    }
};
