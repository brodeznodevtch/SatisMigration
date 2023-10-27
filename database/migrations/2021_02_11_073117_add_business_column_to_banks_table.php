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
        Schema::table('banks', function (Blueprint $table) {
            $table->unsignedInteger('business_id')
                ->nullable()
                ->default(null)
                ->after('name');

            $table->foreign('business_id')
                ->references('id')
                ->on('business');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('banks', function (Blueprint $table) {
            //
        });
    }
};
