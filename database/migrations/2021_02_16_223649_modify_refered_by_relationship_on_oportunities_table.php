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
        Schema::table('oportunities', function (Blueprint $table) {
            $table->dropForeign('oportunities_refered_id_foreign');

            $table->foreign('refered_id')
                ->references('id')
                ->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oportunities', function (Blueprint $table) {
            //
        });
    }
};
