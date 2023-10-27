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
        Schema::table('rrhh_salary_histories', function (Blueprint $table) {
            $table->dropColumn('salary');
            $table->decimal('previous_salary', 10, 2)->nullable();
            $table->decimal('new_salary', 10, 2);
            $table->decimal('percentage', 10, 2);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('rrhh_salary_histories', function (Blueprint $table) {
            $table->dropColumn('previous_salary');
            $table->dropColumn('new_salary');
            $table->dropColumn('percentage');
            $table->dropColumn('deleted_at');
        });
    }
};
