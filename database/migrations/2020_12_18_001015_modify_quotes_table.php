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
            $table->unsignedInteger('state_id')
                ->nullable()
                ->default(null)
                ->after('mobile');
            $table->unsignedInteger('city_id')
                ->nullable()
                ->default(null)
                ->after('state_id');
            $table->string('landmark')
                ->nullable()
                ->default('')
                ->after('address');

            $table->foreign('state_id')
                ->references('id')
                ->on('states');
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            //
        });
    }
};
