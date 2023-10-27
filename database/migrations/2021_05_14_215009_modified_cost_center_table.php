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
        Schema::table('cost_centers', function (Blueprint $table) {
            $table->unsignedInteger('created_by')
                ->after('description')
                ->nullable()
                ->default(null);
            $table->unsignedInteger('updated_by')
                ->after('created_by')
                ->nullable()
                ->default(null);
            $table->softDeletes();

            $table->foreign('created_by')
                ->on('users')
                ->references('id');
            $table->foreign('updated_by')
                ->on('users')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cost_centers', function (Blueprint $table) {
            //
        });
    }
};
